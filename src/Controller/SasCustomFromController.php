<?php declare(strict_types=1);

namespace Sas\CustomForm\Controller;

use Sas\CustomForm\Service\FileUploader;
use Sas\CustomForm\Service\ValidationForm;
use Sas\CustomForm\Struct\Request\SacCustomFormStruct;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Routing\RoutingException;
use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Core\Framework\Context;
use Shopware\Core\Content\Media\File\FileSaver;
use Shopware\Core\Content\Media\File\FileNameProvider;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class SasCustomFromController extends StorefrontController
{
    private FileSaver $mediaUpdater;
    private FileNameProvider $fileNameProvider;
    private EntityRepository $mediaRepository;
    private EntityRepository $formCustomRepository;
    private EntityRepository $mediaFolderRepository;

    public function __construct(
        FileSaver        $mediaUpdater,
        FileNameProvider $fileNameProvider,
        EntityRepository $mediaRepository,
        EntityRepository $formCustomRepository,
        EntityRepository $mediaFolderRepository,
    )
    {
        $this->mediaUpdater = $mediaUpdater;
        $this->fileNameProvider = $fileNameProvider;
        $this->mediaRepository = $mediaRepository;
        $this->formCustomRepository = $formCustomRepository;
        $this->mediaFolderRepository = $mediaFolderRepository;
    }

    /**
     * @Route("/sas/custom/form", name="frontend.sas.custom.form", defaults={"XmlHttpRequest"=true,methods={"POST"}})
     */
    public function uploadMedia(Request $request): JsonResponse
    {
        if (!$request->isXMLHttpRequest()) {
            throw RoutingException::invalidRequestParameter('boundSalesChannelId');
        }

        $data = $request->request->all();
        $media = [
            "error" => false,
            "media_id" => null
        ];

        $validationForm = new ValidationForm($data);
        $validatedData = $validationForm->validate();

        if (empty($validatedData)) {
            return new JsonResponse([
                'error' => true,
                'message' => $this->trans('sas-custom-form.cms-block.custom-form.message.empty')
            ]);
        }

        $sacCustomFormStruct = new SacCustomFormStruct($validatedData, $request->files);
        $context = Context::createDefaultContext();

        if ($sacCustomFormStruct->getFiles() instanceof FileBag) {
            $fileUploader = new FileUploader(
                $this->mediaRepository,
                $this->mediaFolderRepository,
                $this->mediaUpdater,
                $this->fileNameProvider
            );
            $media = $fileUploader->uploadFile($sacCustomFormStruct->getFiles(), $context);
        }

        if ($media['error']) {
            return new JsonResponse([
                'error' => true,
                "message" => $this->trans('sas-custom-form.cms-block.custom-form.message.danger')
            ]);
        }

        $sacCustomFormStruct->setMediaId($media['media_id']);
        $this->insertToTable($sacCustomFormStruct, $context);


        return new JsonResponse([
            'error' => false,
            "message" => $this->trans('sas-custom-form.cms-block.custom-form.message.success')]);
    }

    private function insertToTable(SacCustomFormStruct $data, Context $context)
    {
        $this->formCustomRepository->create([
            [
                "firstName" => $data->getFirstName(),
                "lastName" => $data->getLastName(),
                "email" => $data->getEmail(),
                "company" => $data->getCompany(),
                "phoneNumber" => $data->getPhoneNumber(),
                "street" => $data->getStreet(),
                "streetNumber" => $data->getStreetNumber(),
                "postalCode" => $data->getPostalCode(),
                "country" => $data->getCountry(),
                "city" => $data->getCity(),
                "description" => $data->getDescription(),
                "mediaId" => $data->getMediaId() ?? null,
            ]
        ], $context);
    }
}

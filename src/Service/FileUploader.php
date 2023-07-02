<?php

namespace Sas\CustomForm\Service;

use Shopware\Core\Content\Media\File\FileNameProvider;
use Shopware\Core\Content\Media\File\FileSaver;
use Shopware\Core\Content\Media\File\MediaFile;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Util\Random;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\HttpFoundation\FileBag;
use Sas\CustomForm\SasCustomForm;

final class FileUploader
{
    private EntityRepository $mediaRepository;
    private EntityRepository $mediaFolderRepository;
    private FileSaver $mediaUpdater;
    private FileNameProvider $fileNameProvider;

    public function __construct(
        EntityRepository $mediaRepository,
        EntityRepository $mediaFolderRepository,
        FileSaver        $mediaUpdater,
        FileNameProvider $fileNameProvider
    )
    {
        $this->mediaRepository = $mediaRepository;
        $this->mediaFolderRepository = $mediaFolderRepository;
        $this->mediaUpdater = $mediaUpdater;
        $this->fileNameProvider = $fileNameProvider;
    }

    public function uploadFile(FileBag $files, Context $context): array
    {
        $mediaId = Uuid::randomHex();

        //During the installation of the plugin, a pdf folder is created to store the pdf files.
        //If the admin user had deleted the pdf folder, the file should be saved in the root
        $folderId = $this->getIdFolder($context)[0] ?? null;

        foreach ($files as $file) {

            $fileName = $file->getClientOriginalName();
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

            if ($ext != 'pdf') {
                return [
                    "error" => true,
                ];
            }

            $fileName = $fileName . Random::getInteger(100, 1000);
            $media = [
                [
                    'id' => $mediaId,
                    'name' => $fileName,
                    'fileName' => $fileName,
                    'mimeType' => $file->getClientMimeType(),
                    'fileExtension' => $file->guessExtension(),
                    'mediaFolderId' => $folderId

                ]
            ];

            $mediaId = $this->mediaRepository->create($media, Context::createDefaultContext())->getEvents()->first()->getIds()[0];

            try {
                $this->upload($file, $fileName, $mediaId, $context);
            } catch (\Exception $exception) {
                $fileName = $fileName . '_' . Random::getInteger(100, 1000);
                $this->upload($file, $fileName, $mediaId, $context);
            }

            return [
                "error" => false,
                "media_id" => $mediaId

            ];
        }
    }

    private function upload($file, $fileName, $mediaId, $context): void
    {
        $this->mediaUpdater->persistFileToMedia(
            new MediaFile(
                $file->getRealPath(),
                $file->getMimeType(),
                $file->guessExtension(),
                $file->getSize()
            ),
            $this->fileNameProvider->provide(
                $fileName,
                $file->getExtension(),
                $mediaId,
                $context,

            ),
            $mediaId,
            $context
        );
    }

    /**
     * Retrieves the IDs of the media folders with the name 'PDF File'.
     *
     * @param Context $context The context object.
     * @return array The IDs of the media folders.
     */
    private function getIdFolder(Context $context): array
    {
        // Create criteria to filter media folders by name
        $criteria = new Criteria();
        $criteria->addFilter(
            new EqualsFilter('name', SasCustomForm::FOLDER_NAME)
        );
        // Search for media folders with the specified criteria
        $this->mediaFolderRepository->search($criteria, $context);
        // Retrieve the IDs of the media folders
        return $this->mediaFolderRepository->searchIds($criteria, $context)->getIds();
    }

}

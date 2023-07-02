<?php declare(strict_types=1);

namespace Sas\CustomForm;

use Sas\CustomForm\Content\Form\SasCustomFormDefinition;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Uuid\Uuid;

class SasCustomForm extends Plugin
{
    public const FOLDER_NAME = 'Custom form pdf';

    public function install(InstallContext $installContext): void
    {

        if (empty($this->checkDirectoryExists($installContext->getContext()))) {
            $this->createBlogMediaFolder($installContext->getContext());
        }
    }

    private  function checkDirectoryExists(Context $context):array
    {
        $criteria = new Criteria();
        $criteria->addFilter(
            new EqualsFilter('name', self::FOLDER_NAME)
        );

        /** @var EntityRepository $mediaFolderRepository */
        $mediaFolderRepository = $this->container->get('media_folder.repository');
        $mediaFolderRepository->search($criteria, $context);
        return $mediaFolderRepository->searchIds($criteria, $context)->getIds();
    }


    public function createBlogMediaFolder(Context $context): void
    {
        $criteria = new Criteria();
        $criteria->addFilter(
            new EqualsAnyFilter('entity', [
                SasCustomFormDefinition::ENTITY_NAME,
            ])
        );

        /** @var EntityRepository $mediaFolderRepository */
        $mediaFolderRepository = $this->container->get('media_default_folder.repository');

        $mediaFolderIds = $mediaFolderRepository->searchIds($criteria, $context)->getIds();

        if (!empty($mediaFolderIds)) {
            $ids = array_map(static function ($id) {
                return ['id' => $id];
            }, $mediaFolderIds);
            $mediaFolderRepository->delete($ids, $context);
        }

        /** @var EntityRepository $mediaFolderRepository */
        $mediaFolderRepository = $this->container->get('media_default_folder.repository');

        $data = [
            [
                'entity' => SasCustomFormDefinition::ENTITY_NAME,
                'associationFields' => ['media'],
                'folder' => [
                    'id' =>  Uuid::randomHex(),
                    'name' => self::FOLDER_NAME,
                    'useParentConfiguration' => false,
                    'configuration' => [
                        'createThumbnails' => false,
                        'keepAspectRatio' => false,
                        'thumbnailQuality' => 90,
                    ],
                ],
            ],
        ];
        $mediaFolderRepository->create($data, $context);
    }
}
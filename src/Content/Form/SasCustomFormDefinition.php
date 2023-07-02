<?php declare(strict_types=1);

namespace Sas\CustomForm\Content\Form;

use Sas\CustomForm\Content\Form\SasCustomFormCollection;
use Shopware\Core\Content\Media\MediaDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class SasCustomFormDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'sas_custom_form_table';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return SasCustomFormEntity::class;
    }

    public function getCollectionClass(): string
    {
        return SasCustomFormCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey(), new ApiAware()),
            (new FkField('media_id', 'mediaId', MediaDefinition::class))->addFlags(new ApiAware()),
            (new StringField('first_name', 'firstName'))->addFlags(new Required()),
            (new StringField('last_name', 'lastName'))->addFlags(new Required()),
            (new StringField('email', 'email'))->addFlags(new Required()),
            (new StringField('phone_number', 'phoneNumber')),
            (new StringField('company', 'company'))->addFlags(new Required()),
            (new StringField('street', 'street')),
            (new StringField('street_number', 'streetNumber')),
            (new StringField('postal_code', 'postalCode')),
            (new StringField('country', 'country')),
            (new StringField('city', 'city')),
            (new StringField('description', 'description')),


        ]);
    }
}

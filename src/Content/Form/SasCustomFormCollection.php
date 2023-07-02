<?php declare(strict_types=1);

namespace Sas\CustomForm\Content\Form;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                  add(SasCustomFormEntity $entity)
 * @method void                  set(string $key, SasCustomFormEntity $entity)
 * @method SasCustomFormEntity[]    getIterator()
 * @method SasCustomFormEntity[]    getElements()
 * @method SasCustomFormEntity|null get(string $key)
 * @method SasCustomFormEntity|null first()
 * @method SasCustomFormEntity|null last()
 */
class SasCustomFormCollection extends EntityCollection
{
    public function getApiAlias(): string
    {
        return 'sas_theme_sensorox_form_custom';
    }

    protected function getExpectedClass(): string
    {
        return SasCustomFormEntity::class;
    }
}

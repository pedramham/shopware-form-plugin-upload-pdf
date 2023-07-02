import './component';
import './preview';

Shopware.Component.register('sw-cms-block-sas-custom-form', () => import('./component'));
Shopware.Component.register('sw-cms-preview-sas-custom-form', () => import('./preview'));

Shopware.Service('cmsService').registerCmsBlock({
    name: 'sas-custom-form',
    label: 'sas-custom-form.blocks.label',
    category: 'form',
    component: 'sw-cms-block-sas-custom-form',
    previewComponent: 'sw-cms-preview-sas-custom-form',
    slots: {}
});

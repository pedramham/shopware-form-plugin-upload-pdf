const { Module } = Shopware;
import './page/sas-custom-form-list';
import './page/sas-custom-form-detail';
/**
 * Language Snippets
 */
import deDE from './../snippet/de-DE.json';
import enGB from './../snippet/en-GB.json';

Module.register('sas-custom-form', {
    type: 'plugin',
    name: 'sas-custom-form',
    title:  'sas-custom-form.page.name',
    description: 'sas-custom-form.descriptionTextModule',
    color: '#F965AF',
    icon: 'default-symbol-content',

    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },

    routes: {
        index: {
            components: {
                default: 'sas-custom-form-list'
            },
            path: 'index',
        },
        create: {
            components: {
                default: 'sas-custom-form-detail'
            },
            path: 'create'
        },
        detail: {
            component: 'sas-custom-form-detail',
            path: 'detail/:id',
            props: {
                default: (route) => {
                    return {
                        customFormId: route.params.id,
                    };
                },
            },
        },
    },

    navigation: [
        {
            id: 'sas-custom-form',
            label:  'sas-custom-form.name',
            path: 'sas.custom.form.index',
            parent: 'sw-content',
            meta: {
                privilege: [
                    'sas_custom_form_entries:read',
                ],
            }
        }
    ]
});

const {Component, Mixin} = Shopware;
import template from './sas-custom-form-detail.html.twig';
import './sas-custom-form-detail.scss';

const Criteria = Shopware.Data.Criteria;
const {mapPropertyErrors} = Shopware.Component.getComponentHelper();

Component.register('sas-custom-form-detail', {
    template,

    inject: [
        'repositoryFactory',
    ],

    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },

    props: {
        customFormId: {
            type: String,
            required: false,
            default() {
                return null;
            },
        },
    },

    data() {
        return {
            customForm: null,
            salesChannels: null,
            download: null,
            isLoading: true,
        };
    },

    created() {
        this.createdComponent();
    },

    computed: {
        customFormRepository() {
            return this.repositoryFactory.create('sas_custom_form_table');
        },

        mediaRepository() {
            return this.repositoryFactory.create('media');
        },

        isCreateMode() {
            return this.$route.name === 'sas.custom.form.create';
        },

    },

    methods: {
        async createdComponent() {

            await Promise.all([
                this.getCustomForm(),
                this.getMediaUrlPathForDownload()
            ]);
            this.isLoading = false;
        },

        async getCustomForm() {
            if (!this.customFormId) {
                this.customForm = this.customFormRepository.create(Shopware.Context.api);

                return;
            }

            const criteria = new Criteria();
            return this.customFormRepository
                .get(this.customFormId, Shopware.Context.api, criteria)
                .then((entity) => {
                    this.customForm = entity;
                });

        },

        async getMediaUrlPathForDownload() {
            await this.getCustomForm();
            const criteria = new Criteria();
            return this.mediaRepository
                .get(this.customForm.mediaId, Shopware.Context.api, criteria)

                .then((entity) => {
                    this.download = entity?.url;
                });
        },

        onCancel() {
            this.$router.push({name: 'sas.custom.form.index'});
        }

    }
});

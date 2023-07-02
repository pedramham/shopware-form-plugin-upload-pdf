import template from './sas-custom-form.twig';

const {Component, Mixin} = Shopware;
const Criteria = Shopware.Data.Criteria;

Component.register('sas-custom-form-list', {
    template,

    inject: ['repositoryFactory'],

    data() {
        return {
            repository: null,
            customForm: null,
            total: 0,
            isLoading: true,
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },

    computed: {

        columns() {
            return [
                {
                    property: 'firstName',
                    label: this.$tc('sas-custom-form.page.list.table.name'),
                    routerLink: 'sas.custom.form.detail',
                },
                {
                    property: 'lastName',
                    label: this.$tc('sas-custom-form.page.list.table.name'),
                    routerLink: 'sas.custom.form.detail',
                },
                {
                    property: 'company',
                    label: this.$tc('sas-custom-form.page.list.table.company'),
                },
                {
                    property: 'email',
                    label: this.$tc('sas-custom-form.page.list.table.email'),
                }
            ];
        }
    },


    created() {
        this.isLoading = true;

        this.repository = this.repositoryFactory.create('sas_custom_form_table');
        const criteria = new Criteria();
        criteria.addSorting(Criteria.sort('createdAt', 'DESC', false))

        this.repository.search(new Criteria(), Shopware.Context.api).then(result => {
            this.total = result.total;
            this.customForm = result;
            this.isLoading = false;
        });
    }

});

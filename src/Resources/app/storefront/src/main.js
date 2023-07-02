import SasCustomForm from './sas-custom-form/custom-form'
const PluginManager = window.PluginManager;

PluginManager.register('SasCustomForm', SasCustomForm,'[data-sas-custom-form]');

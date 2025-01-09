pimcore.registerNS("pimcore.plugin.SolveXTaskBundle");

pimcore.plugin.SolveXTaskBundle = Class.create({
    initialize: function () {
        document.addEventListener(pimcore.events.preMenuBuild, this.preMenuBuild.bind(this));
    },

    preMenuBuild: function (e) {
        const perspectiveCfg = pimcore.globalmanager.get("perspective");
        
        if (perspectiveCfg.inToolbar("solvextask") === false) {
            return;
        }

        let menu = e.detail.menu;
        menu.solvextask = {
            label: t('plugin_solvextask_toolbar'),
            iconCls: 'solvex_icon_create_product',
            priority: 55,
            shadow: false,
            handler: this.openProductForm.bind(this), 
            cls: "pimcore_navigation_flyout",
            noSubmenus: true
        };
    },

    openProductForm: function () {
        const productForm = new pimcore.plugin.SolveXTaskBundle.ProductForm();
        productForm.open();
    }
});

var SolveXTaskBundlePlugin = new pimcore.plugin.SolveXTaskBundle();
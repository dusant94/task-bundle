pimcore.registerNS("pimcore.plugin.SolveXTaskBundle.ProductForm");

pimcore.plugin.SolveXTaskBundle.ProductForm = Class.create({
    open: function () {
        Ext.create("Ext.window.Window", {
            title: "Create or Update Product",
            width: 400,
            height: 300,
            layout: "fit",
            modal: true,
            items: [
                {
                    xtype: "form",
                    bodyPadding: 10,
                    defaults: { anchor: "100%" },
                    items: [
                        {
                            xtype: "textfield",
                            name: "sku",
                            fieldLabel: "SKU",
                            allowBlank: false
                        },
                        {
                            xtype: "textfield",
                            name: "name",
                            fieldLabel: "Name"
                        },
                        {
                            xtype: "numberfield",
                            name: "price",
                            fieldLabel: "Price",
                            allowBlank: false,
                        }
                    ],
                    buttons: [
                        {
                            text: "Submit",
                            handler: function (button) {
                                const form = button.up("form").getForm();
                                if (form.isValid()) {
                                    const values = form.getValues();
                                    Ext.Ajax.request({
                                        url: "/product/create-or-update",
                                        method: "POST",
                                        jsonData: values,
                                        success: function (response) {
                                            const data = Ext.decode(response.responseText);
                                            if (data.success) {
                                                pimcore.helpers.showNotification(
                                                    "Success",
                                                    data.message,
                                                    "success"
                                                );
                                            } else {
                                                pimcore.helpers.showNotification(
                                                    "Error",
                                                    data.message,
                                                    "error"
                                                );
                                            }
                                        },
                                        failure: function (response) {
                                            let errorMessage = "An unexpected error occurred.";
                                            if (response.status === 500) {
                                                try {
                                                    const data = Ext.decode(response.responseText);
                                                    errorMessage = data.message || errorMessage;
                                                } catch (e) {

                                                }
                                            }
                                            pimcore.helpers.showNotification(
                                                "Error",
                                                errorMessage,
                                                "error"
                                            );
                                        }
                                    });
                                } else {
                                    pimcore.helpers.showNotification(
                                        "Validation",
                                        "Please fill all required fields.",
                                        "warning"
                                    );
                                }
                            }
                        }
                    ]
                }
            ]
        }).show();
    }
});
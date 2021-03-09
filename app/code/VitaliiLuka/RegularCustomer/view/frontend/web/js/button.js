define([
    'jquery',
    'jquery/ui',
    'Magento_Ui/js/modal/alert'
], function ($, alert) {
    'use strict';

    $.widget('vitaliiLuka.regularCustomerButton', {
        options: {
            url: '',
            productId: ''
        },

        /**
         * Constructor
         * @private
         */
        _create: function () {
            this.ajaxRequest();
            $(this.element).click(this.openRequestForm.bind(this));
        },

        /**
         * Generate event to open the form
         */
        openRequestForm: function () {
            $(document).trigger('vitalii_luka_regular_customer_form_open');
        },

        /**
         * Generate event to show message
         */
        customerShowMessage: function () {
            $(document).trigger('vitalii_luka_regular_customer_show_message');
            $(this.element).hide();
        },

        /**
         * Submit request via AJAX. Add product id to the post data.
         */
        ajaxRequest: function () {
            $.ajax({
                url: this.options.url,
                data: {
                    'isAjax': 1,
                    'product_id': this.options.productId
                },
                type: 'get',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                success: function (response) {
                    if (response.requestSubmitted) {
                        this.openRequestForm();
                    } else {
                        this.customerShowMessage();
                    }
                },

                /** @inheritdoc */
                error: function () {
                    alert({
                        title: $.mage.__('Error'),
                        content: $.mage.__('Your request can\'t be sent. Please, contact us if you see this message.')
                    });
                }
            });
        }
    });

    return $.vitaliiLuka.regularCustomerButton;
});

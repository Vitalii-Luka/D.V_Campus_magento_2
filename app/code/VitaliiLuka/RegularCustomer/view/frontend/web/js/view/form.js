define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/modal',
    'mage/translate',
    'mage/cookies'
], function ($, ko, Component, customerData, alert) {
    'use strict';

    return Component.extend({
        defaults: {
            customerName: '',
            customerEmail: '',
            template: 'VitaliiLuka_RegularCustomer/form'
        },

        initObservable: function () {
            this._super();
            this.observe(['customerName', 'customerEmail']);

            this.customerName.subscribe(function (newValue) {
                console.log(newValue);
            });

            return this;
        },

        /**
         * Send form data to the server
         */
        sendPersonalDiscountRequest: function () {
            console.log('Going to submit the form');
        }
    });

    $.widget('vitaliiLuka.regularCustomerForm', {
        options: {
            action: '',
            productId: ''
        },

        /**
         * @private
         */
        _create: function () {
            $(this.element).modal({
                buttons: []
            });

            $(document).on('vitalii_luka_regular_customer_form_open', this.openModal.bind(this));
            $(this.element).on('submit.vitalii_luka_regular_customer_form', this.sendRequest.bind(this));

            this.updateCustomerData(customerData.get('personal-discount')())
            customerData.get('personal-discount').subscribe(this.updateCustomerData.bind(this));
        },

        updateCustomerData: function (value) {
            $(this.element).find('input[name="email"]').val(value.email);
            if (value.productIds !== undefined &&
                value.productIds.indexOf(this.options.productId) !== -1) {
                $('#vitalii-luka-regular-customer-tab .action.primary').hide();
                $(document).trigger('vitalii_luka_regular_customer_show_message');
            }
        },

        /**
         * Open modal dialog
         */
        openModal: function () {
            $(this.element).modal('openModal');
        },

        /**
         * Validate form and send request
         */
        sendRequest: function () {
            if (!this.validateForm()) {
                return;
            }

            this.ajaxSubmit();
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            let formData = new FormData($(this.element).get(0));

            formData.append('product_id', this.options.productId);
            formData.append('form_key', $.mage.cookies.get('form_key'));
            formData.append('isAjax', 1);

            $.ajax({
                url: this.options.action,
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                /** @inheritdoc */
                success: function (response) {
                    $(this.element).modal('closeModal');
                    alert({
                        title: $.mage.__('Success'),
                        content: response.message
                    });
                },

                /** @inheritdoc */
                error: function () {
                    alert({
                        title: $.mage.__('Error'),
                        /*eslint max-len: ["error", { "ignoreStrings": true }]*/
                        content: $.mage.__('Your request can\'t be sent. Please, contact us if you see this message.')
                    });
                },

                /** @inheritdoc */
                complete: function () {
                    $('body').trigger('processStop');
                }
            });
        }
    });

});

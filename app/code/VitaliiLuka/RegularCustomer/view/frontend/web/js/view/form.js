define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'vitaliiLukaRegularCustomerSubmitForm',
    'Magento_Ui/js/modal/modal',
    'mage/cookies'
], function ($, ko, Component, customerData, submitFormAction) {
    'use strict';

    return Component.extend({
        defaults: {
            action: '',
            customerName: '',
            customerEmail: '',
            isLoggedIn: !!customerData.get('personal-discount')().isLoggedIn,
            hideIt: '',
            productId: 0,
            template: 'VitaliiLuka_RegularCustomer/form'
        },

        /**
         * @returns {*}
         */
        initObservable: function () {
            this._super();
            this.observe(['customerName', 'customerEmail', 'isLoggedIn', 'hideIt']);

            this.updatePersonalDiscountData(customerData.get('personal-discount')());
            customerData.get('personal-discount').subscribe(this.updatePersonalDiscountData.bind(this));

            return this;
        },

        /**
         * Update observable values with the ones from the localStorage
         * @param {Object} personalDiscountData
         */
        updatePersonalDiscountData: function (personalDiscountData) {
            if (personalDiscountData.hasOwnProperty('name')) {
                this.customerName(personalDiscountData.name);
            }

            if (personalDiscountData.hasOwnProperty('email')) {
                this.customerEmail(personalDiscountData.email);
            }

            this.isLoggedIn(personalDiscountData.isLoggedIn);
        },

        /**
         * Initialize modal window on form
         * @param element
         */
        initModal: function (element) {
            this.$form = $(element);
            this.$modal = this.$form.modal({
                buttons: []
            });

            $(document).on('vitalii_luka_regular_customer_form_open', this.openModal.bind(this));
        },

        /**
         * Open modal dialog
         */
        openModal: function () {
            this.$modal.modal('openModal');
        },

        /**
         * Send form data to the server
         */
        sendPersonalDiscountRequest: function () {
            if (!this.validateForm()) {
                return;
            }

            this.ajaxSubmit();
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return this.$form.validation().valid();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            let payload = {
                name: this.customerName(),
                email: this.customerEmail(),
                'product_id': this.productId,
                'form_key': $.mage.cookies.get('form_key'),
                isAjax: 1,
                'hide_it': this.hideIt()
            };

            submitFormAction(payload, this.action)
                .done(function () {
                    this.$modal.modal('closeModal');
                }.bind(this));
        }
    });
});

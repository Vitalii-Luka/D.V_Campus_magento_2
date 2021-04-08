define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'Magento_Customer/js/model/authentication-popup',
    'Magento_Customer/js/action/login',
    'vitaliiLukaRegularCustomerForm'
], function ($, ko, Component, customerData, authenticationPopup, loginAction) {
    'use strict';

    return Component.extend({
        defaults: {
            productId: 0,
            allowForGuests: !!customerData.get('personal-discount')().allowForGuests,
            requestAlreadySent: false,
            template: 'VitaliiLuka_RegularCustomer/button',
            personalDiscount: customerData.get('personal-discount')
        },

        /**
         * @returns {*}
         */
        initialize: function () {
            loginAction.registerLoginCallback(function () {
                customerData.invalidate(['*']);
            });

            this._super();

            this.checkRequestAlreadySent(this.personalDiscount());
            this.openRequestFormAfterSectionReload = false;

            return this;
        },

        /**
         * @returns {*}
         */
        initObservable: function () {
            this._super().observe(['requestAlreadySent', 'allowForGuests']);

            return this;
        },

        /**
         * Generate event to open the form
         */
        openRequestForm: function () {
            if (Object.keys(this.personalDiscount()).length > 0) {
                if (this.allowForGuests() || !!this.personalDiscount().isLoggedIn) {
                    $(document).trigger('vitalii_luka_regular_customer_form_open');
                } else {
                    authenticationPopup.showModal();
                }
            } else {
                this.openRequestFormAfterSectionReload = true;
                customerData.reload(['personal-discount']);
            }
        },

        /**
         * Check if the product has already been requested by the customer
         */
        checkRequestAlreadySent: function (personalDiscountData) {
            if (personalDiscountData.hasOwnProperty('productIds') &&
                personalDiscountData.productIds.indexOf(this.productId) !== -1
            ) {
                this.requestAlreadySent(true);
            }

            this.allowForGuests(!!personalDiscountData.allowForGuests);

            if (this.openRequestFormAfterSectionReload) {
                this.openRequestFormAfterSectionReload = false;
                this.openRequestForm();
            }

            return personalDiscountData;
        }
    });
});

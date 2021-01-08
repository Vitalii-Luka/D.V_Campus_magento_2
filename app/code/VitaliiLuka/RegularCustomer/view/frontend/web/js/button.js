define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('vitaliiLuka.regularCustomerButton', {
        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(this.element).click(this.openRequestForm.bind(this));
        },

        /**
         * Generate event to open the form
         */
        openRequestForm: function () {
            $(document).trigger('vitalii_luka_regular_customer_form_open');
        }
    });

    return $.vitaliiLuka.regularCustomerButton;
});

define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('vitaliiLuka.regularCustomerMessage', {
        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(document).on('vitalii_luka_regular_customer_show_message', this.showMessage.bind(this));
        },

        /**
         * Generate event to show message
         */
        showMessage: function () {
            $(this.element).show();
        }
    });

    return $.vitaliiLuka.regularCustomerMessage;
});

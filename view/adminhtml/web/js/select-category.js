/**
 * select-category
 *
 * @copyright Copyright © 2020 landofcoder. All rights reserved.
 * @author    landofcoder@gmail.com
 */

define([
    'Magento_Ui/js/form/element/ui-select'
], function (Select) {
    'use strict';

    return Select.extend({

        /**
         * Parse data and set it to options.
         *
         * @param {Object} data - Response data object.
         * @returns {Object}
         */
        setParsed: function (data) {
            var option = this.parseData(data);

            if (data.error) {
                return this;
            }

            this.options([]);
            this.setOption(option);
            this.set('newOption', option);
        },

        /**
         * Normalize option object.
         *
         * @param {Object} data - Option object.
         * @returns {Object}
         */
        parseData: function (data) {
            return {
                'category_id': data.category['category_id'],
                level: data.category.level,
                value: data.category['banner_id'],
                label: data.category.name,
                parent: data.category.parent,
            };
        }
    });
});

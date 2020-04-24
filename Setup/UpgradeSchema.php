<?php
/**
 * Copyright (c) 2019 landofcoder.com
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Lof\CategoryBannerSlider\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class UpgradeSchema
 *
 * @package Lof\CategoryBannerSlider\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.2.5', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('lof_category_banner'),
                'customer_group_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'unsigned' => true,
                    'comment' => 'Customer Group'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('lof_category_banner'),
                'banner_width',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'unsigned' => true,
                    'comment' => 'Banner Width'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('lof_category_banner'),
                'banner_height',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'unsigned' => true,
                    'comment' => 'Banner Height'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('lof_category_banner'),
                'url_image',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    [],
                    'size' => 255,
                    'comment' => 'URL On Image Click'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('lof_category_banner'),
                'show_banner_content',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'unsigned' => true,
                    'comment' => 'Show Banner Content'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('lof_category_banner'),
                'show_banner_title',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'unsigned' => true,
                    'comment' => 'Show Banner Title'
                ]
            );
        }

        $installer->endSetup();
    }
}

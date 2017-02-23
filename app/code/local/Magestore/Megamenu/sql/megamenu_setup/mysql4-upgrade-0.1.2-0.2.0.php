<?php
/**
 *
 *  Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 *  Do not edit or add to this file if you wish to upgrade this extension to newer
 *  version in the future.
 *
 *  @category    Magestore
 *  @package     Magestore_Megamenu
 *  @module   Megamenu
 *  @author   Magestore Developer
 *
 *  @copyright   Copyright (c) 2016 Magestore (http://www.magestore.com/)
 *  @license     http://www.magestore.com/license-agreement.html
 */

$installer = $this;

$installer->startSetup();
$installer->run("

DROP TABLE IF EXISTS {$this->getTable('megamenu/itemtemplate')};

CREATE TABLE {$this->getTable('megamenu/itemtemplate')} (
  `template_id` int(10) unsigned NOT NULL auto_increment,
  `menu_type` int unsigned,
  `name` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'menu_type', 'int unsigned NOT NULL default "0"');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'template_id', 'int unsigned NOT NULL default "0"');
//$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'category_ids', 'text NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'products', 'text NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'products_box_title', 'varchar(255) NOT NULL default "Products"');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'categories_box_title', 'varchar(255) NOT NULL default "Categories"');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'header', 'text NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'footer', 'text NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'featured_type', 'smallint(2) NOT NULL default "0"');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'featured_products', 'text NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'featured_products_box_title', 'varchar(255) NOT NULL default "Featured Products"');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'featured_categories', 'text NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'featured_categories_box_title', 'varchar(255) NOT NULL default "Featured Categories"');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'number_column', 'int unsigned');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'size_bar', 'int unsigned');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'border_size', 'int unsigned');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'background_color', 'text NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'border_color', 'text NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'title_color', 'text NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'title_background_color', 'text NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'title_font', 'text NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'title_font_size', 'int unsigned default "0"');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'subtitle_color', 'text NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'subtitle_font', 'text NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'subtitle_font_size', 'int unsigned default "0"');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'link_color', 'text NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'hover_color', 'text NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'link_font', 'text NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'link_font_size', 'int unsigned default "0"');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'text_color', 'text NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'text_font', 'text NOT NULL default ""');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'text_font_size', 'int unsigned default "0"');
$installer->getConnection()->addColumn($installer->getTable('megamenu/megamenu'), 'item_icon', 'text NULL default ""');


$data = array(
    array(
        'menu_type' => '1',
        'name' => 'Content Only 01',
        'filename' => 'default.phtml'
    ),
   
    array(
        'menu_type' => '2',
        'name' => 'Product Listing 01',
        'filename' => 'detailed_products.phtml'
    ),
    array(
        'menu_type' => '2',
        'name' => 'Product Listing 02',
        'filename' => 'general_products.phtml'
    ),
	
    array(
        'menu_type' => '3',
        'name' => 'Category Listing 01',
        'filename' => 'detailed_categories.phtml'
    ),
    array(
        'menu_type' => '3',
        'name' => 'Category Listing 02',
        'filename' => 'general_categories.phtml'
    ),
   
    array(
        'menu_type' => '4',
        'name' => 'Contact Form 01',
        'filename' => 'default.phtml'
    ),
    array(
        'menu_type' => '5',
        'name' => 'Group Meu Items 01',
        'filename' => 'default.phtml'
    ),
    
    array(
        'menu_type' => '6',
        'name' => 'Anchor Text 01',
        'filename' => 'default.phtml'
    )
);

$installer->getConnection()->insertMultiple($installer->getTable('megamenu/itemtemplate'), $data);
	
$installer->endSetup();
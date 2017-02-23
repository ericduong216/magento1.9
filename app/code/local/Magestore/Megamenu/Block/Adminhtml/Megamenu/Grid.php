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

/**
 * Class Magestore_Megamenu_Block_Adminhtml_Megamenu_Grid
 */
class Magestore_Megamenu_Block_Adminhtml_Megamenu_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Magestore_Megamenu_Block_Adminhtml_Megamenu_Grid constructor.
     */
    public function __construct(){
            parent::__construct();
            $this->setId('megamenuGrid');
            $this->setDefaultSort('megamenu_id');
            $this->setDefaultDir('ASC');
            $this->setSaveParametersInSession(true);
    }

    /**
     * @return mixed
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('megamenu/megamenu')->getCollection();
        if(!$this->getRequest()->getParam('filter')){
            foreach($collection as $item){
                $stores =  explode(',',$item->getStores());
                $item->setStoreId($stores);
            }
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @param $data
     * @return $this
     */
    protected function _setFilterValues($data)
    {
        foreach ($this->getColumns() as $columnId => $column) {
            if (isset($data[$columnId])
                && (!empty($data[$columnId]) || strlen($data[$columnId]) > 0)
                && $column->getFilter()
            ) {
                $column->getFilter()->setValue($data[$columnId]);
                $this->_addColumnFilterToCollection($column);
            }
        }
        $collection = $this->getCollection();
        foreach($collection as $item){
            $stores =  explode(',',$item->getStores());
            $item->setStoreId($stores);
        }
        $this->setCollection($collection);
        return $this;
    }

    /**
     * @return mixed
     */
    protected function _prepareColumns(){
            $this->addColumn('megamenu_id', array(
                    'header'	=> Mage::helper('megamenu')->__('ID'),
                    'align'	 =>'right',
                    'width'	 => '50px',
                    'index'	 => 'megamenu_id',
            ));

            $this->addColumn('name_menu', array(
                    'header'	=> Mage::helper('megamenu')->__('Name'),
                    'align'	 =>'left',
                    'index'	 => 'name_menu',
            ));
            $this->addColumn('megamenu_type', array(
                'header'    =>  Mage::helper('megamenu')->__('Menu Type'),
                'align'     =>  'left',
                'index'     =>  'megamenu_type',
                'type'      =>  'options',
                'options'   =>  Mage::helper('megamenu')->megamenuTypeToOptionArray(),
            ));
            $this->addColumn('menu_type', array(
                'header'    =>  Mage::helper('megamenu')->__('SubMenu Type'),
                'align'     =>  'left',
                'index'     =>  'menu_type',
                'type'      =>  'options',
                'options'   =>  Mage::helper('megamenu')->menuTypeToOptionArray(),
            ));
            $this->addColumn('link', array(
                    'header'	=> Mage::helper('megamenu')->__('Link'),
                    'align'	 =>'left',
                    'index'	 => 'link',
            ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('cms')->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'
                => array($this, '_filterStoreCondition'),
            ));
        }
            $this->addColumn('status', array(
                    'header'	=> Mage::helper('megamenu')->__('Status'),
                    'align'	 => 'left',
                    'width'	 => '80px',
                    'index'	 => 'status',
                    'type'		=> 'options',
                    'options'	 => array(
                            1 => 'Enabled',
                            2 => 'Disabled',
                    ),
            ));
            $this->addColumn('sort_order', array(
                    'header'	=> Mage::helper('megamenu')->__('Sort Order'),
                    'width'	 => '50px',
                    'index'	 => 'sort_order',           			
            ));

            $this->addColumn('action',
                    array(
                            'header'	=>	Mage::helper('megamenu')->__('Action'),
                            'width'		=> '100',
                            'type'		=> 'action',
                            'getter'	=> 'getId',
                            'actions'	=> array(
                                    array(
                                            'caption'	=> Mage::helper('megamenu')->__('Edit'),
                                            'url'		=> array('base'=> '*/*/edit'),
                                            'field'		=> 'id'
                                    )),
                            'filter'	=> false,
                            'sortable'	=> false,
                            'index'		=> 'stores',
                            'is_system'	=> true,
            ));

            $this->addExportType('*/*/exportCsv', Mage::helper('megamenu')->__('CSV'));
            $this->addExportType('*/*/exportXml', Mage::helper('megamenu')->__('XML'));

            return parent::_prepareColumns();
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction(){
            $this->setMassactionIdField('megamenu_id');
            $this->getMassactionBlock()->setFormFieldName('megamenu');

            $this->getMassactionBlock()->addItem('delete', array(
                    'label'		=> Mage::helper('megamenu')->__('Delete'),
                    'url'		=> $this->getUrl('*/*/massDelete'),
                    'confirm'	=> Mage::helper('megamenu')->__('Are you sure?')
            ));

            $statuses = Mage::getSingleton('megamenu/status')->getOptionArray();

            array_unshift($statuses, array('label'=>'', 'value'=>''));
            $this->getMassactionBlock()->addItem('status', array(
                    'label'=> Mage::helper('megamenu')->__('Change status'),
                    'url'	=> $this->getUrl('*/*/massStatus', array('_current'=>true)),
                    'additional' => array(
                            'visibility' => array(
                                    'name'	=> 'status',
                                    'type'	=> 'select',
                                    'class'	=> 'required-entry',
                                    'label'	=> Mage::helper('megamenu')->__('Status'),
                                    'values'=> $statuses
                            ))
            ));
            $this->getMassactionBlock()->addItem('rebuild', array(
                'label'		=> Mage::helper('megamenu')->__('Re-Build'),
                'url'		=> $this->getUrl('*/*/massRebuild'),
                'confirm'	=> Mage::helper('megamenu')->__('Are you sure?')
            ));
            return $this;
    }

    /**
     * @param $collection
     * @param $column
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addStoreFilter($value);
    }

    /**
     * @param $row
     * @return mixed
     */
    public function getRowUrl($row){
            return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
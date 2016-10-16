<?php
/**
 * Icommkt_EmailExporter extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Icommkt
 * @package        Icommkt_EmailExporter
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Email admin edit tabs
 *
 * @category    Icommkt
 * @package     Icommkt_EmailExporter
 * @author      Ultimate Module Creator
 */
class Icommkt_EmailExporter_Block_Adminhtml_Email_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('email_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('icommkt_emailexporter')->__('Email'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Icommkt_EmailExporter_Block_Adminhtml_Email_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_email',
            array(
                'label'   => Mage::helper('icommkt_emailexporter')->__('Email'),
                'title'   => Mage::helper('icommkt_emailexporter')->__('Email'),
                'content' => $this->getLayout()->createBlock(
                    'icommkt_emailexporter/adminhtml_email_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_email',
                array(
                    'label'   => Mage::helper('icommkt_emailexporter')->__('Store views'),
                    'title'   => Mage::helper('icommkt_emailexporter')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'icommkt_emailexporter/adminhtml_email_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve email entity
     *
     * @access public
     * @return Icommkt_EmailExporter_Model_Email
     * @author Ultimate Module Creator
     */
    public function getEmail()
    {
        return Mage::registry('current_email');
    }
}

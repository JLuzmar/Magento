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
 * Email admin block
 *
 * @category    Icommkt
 * @package     Icommkt_EmailExporter
 * @author      Ultimate Module Creator
 */
class Icommkt_EmailExporter_Block_Adminhtml_Email extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        $this->_controller         = 'adminhtml_email';
        $this->_blockGroup         = 'icommkt_emailexporter';
        parent::__construct();
        $this->_headerText         = Mage::helper('icommkt_emailexporter')->__('Email');
        $this->_updateButton('add', 'label', Mage::helper('icommkt_emailexporter')->__('Add Email'));

    }
}

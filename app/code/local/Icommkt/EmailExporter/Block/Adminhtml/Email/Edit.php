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
 * Email admin edit form
 *
 * @category    Icommkt
 * @package     Icommkt_EmailExporter
 * @author      Ultimate Module Creator
 */
class Icommkt_EmailExporter_Block_Adminhtml_Email_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        parent::__construct();
        $this->_blockGroup = 'icommkt_emailexporter';
        $this->_controller = 'adminhtml_email';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('icommkt_emailexporter')->__('Save Email')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('icommkt_emailexporter')->__('Delete Email')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('icommkt_emailexporter')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_email') && Mage::registry('current_email')->getId()) {
            return Mage::helper('icommkt_emailexporter')->__(
                "Edit Email '%s'",
                $this->escapeHtml(Mage::registry('current_email')->getEmail())
            );
        } else {
            return Mage::helper('icommkt_emailexporter')->__('Add Email');
        }
    }
}

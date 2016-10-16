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
 * Email edit form tab
 *
 * @category    Icommkt
 * @package     Icommkt_EmailExporter
 * @author      Ultimate Module Creator
 */
class Icommkt_EmailExporter_Block_Adminhtml_Email_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Icommkt_EmailExporter_Block_Adminhtml_Email_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('email_');
        $form->setFieldNameSuffix('email');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'email_form',
            array('legend' => Mage::helper('icommkt_emailexporter')->__('Email'))
        );

        $fieldset->addField(
            'email',
            'text',
            array(
                'label' => Mage::helper('icommkt_emailexporter')->__('email'),
                'name'  => 'email',
                'required'  => true,
                'class' => 'required-entry',

           )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('icommkt_emailexporter')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('icommkt_emailexporter')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('icommkt_emailexporter')->__('Disabled'),
                    ),
                ),
            )
        );
        if (Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_email')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_email')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getEmailData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getEmailData());
            Mage::getSingleton('adminhtml/session')->setEmailData(null);
        } elseif (Mage::registry('current_email')) {
            $formValues = array_merge($formValues, Mage::registry('current_email')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}

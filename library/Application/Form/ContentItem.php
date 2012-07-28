<?php

class Application_Form_ContentItem extends Pike_Form
{

    public function init()
    {
        $element = new Zend_Form_Element_Text('title');
        $element->setLabel('Title')
            ->setRequired(true)
            ->addValidator(new Zend_Validate_StringLength(array(
                    'min' => 30, 'max' => 200
                )))
            ->addFilter(new Zend_Filter_StripTags());

        $this->addElement($element);

        $element = new Zend_Form_Element_Text('pageTitle');
        $element->setLabel('Page title')
            ->setRequired(true)
            ->addValidator(new Zend_Validate_StringLength(array(
                    'min' => 30, 'max' => 160
                )))
            ->addFilter(new Zend_Filter_StripTags());

        $this->addElement($element);

        $element = new Zend_Form_Element_Textarea('abstract');
        $element->setLabel('Summary')
            ->setRequired(true)
            ->setAttrib('class', 'HTMLSimple');

        $this->addElement($element);
        
        $element = new Zend_Form_Element_Textarea('content');
        $element->setLabel('Page description')
            ->setRequired(true)
            ->setAttrib('class', 'HTMLAdvanced');

        $this->addElement($element);
        
        $this->addSubmitButton(new Zend_Form_Element_Submit('save', array(
                'label' => 'Save'
            )));

        $this->addSubmitButton(new Zend_Form_Element_Button('cancel', array(
                'label' => 'Cancel'
            )));
    }

}
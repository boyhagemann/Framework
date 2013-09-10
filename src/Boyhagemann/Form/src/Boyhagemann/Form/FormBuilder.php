<?php

namespace Boyhagemann\Form;

use Symfony\Component\Form\FormBuilder as FormFactory;
use Boyhagemann\Form\Element\InputElement;
use Boyhagemann\Form\Element\CheckableElement;
use Boyhagemann\Form\Element\ModelElement;
use Event;

class FormBuilder
{
	/**
	 * @var string
	 */
	protected $name;

    /**
     * @var FormFactory
     */
    protected $factory;
    
    protected $elements = array();

    /**
     * @param FormFactory $factory
     */
    public function __construct()
    {
        $this->factory = \App::make('Symfony\Component\Form\FormBuilder');
    }

	/**
	 * @param string $name
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param $name
	 * @return InputElement
	 */
	public function get($name)
    {
        return $this->elements[$name];
    }

    /**
     * 
     * @param array $values
     * @return $this
     */
    public function defaults(Array $values = array())
    {
        foreach ($this->elements as $name => $element) {
            if (isset($values[$name])) {
                $element->value($values[$name]);
            }
        }

        return $this;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function build()
    {
        $reference = $this;
        $factory = $this->factory;
        
        Event::fire('formBuilder.build.pre', compact('factory', 'reference'));
        
        foreach ($this->elements as $name => $element) {
            
            Event::fire('formBuilder.buildElement.pre', compact('name', 'element', 'factory', 'reference'));

			$options = $element->getOptions() + array('attr' => $element->getAttributes());
            $this->factory->add($name, $element->getFormType(), $options);

            Event::fire('formBuilder.buildElement.post', compact('name', 'element', 'factory', 'reference'));
            
        }
        
        Event::fire('formBuilder.build.post', compact('factory', 'reference'));

        return $this->getFactory()->getForm();
    }

    /**
     * @return mixed
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param       $element
     * @return InputElement
     */
    protected function addElement(InputElement $element)
    {
        $reference = $this;
		$name = $element->getName();
        
        Event::fire('formBuilder.addElement.pre', compact('name', 'element', 'reference'));

        $this->elements[$name] = $element;
        
        Event::fire('formBuilder.addElement.post', compact('name', 'element', 'reference'));
        
        return $element;
    }
    
    /**
     * 
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
	 * @return array
	 */
	public function toArray()
	{
		$config = array();

		foreach($this->elements as $element) {
			$config[] = $element->toArray();
		}

		return $config;
	}

	/**
	 * @param array $config
	 * @return $this
	 */
	public function fromArray(Array $config)
	{
		foreach($config as $data) {

			if(!isset($data['type'])) {
				continue;
			}

			if(!isset($data['name'])) {
				continue;
			}

			$type = $data['type'];
			$name = $data['name'];

			unset($data['type']);
			unset($data['name']);

			$element = $this->{$type}($name);

			foreach($data as $key => $value) {
				$element->{$key}($value);
			}

		}

		return $this;
	}

        public function action($action)
        {
            $this->factory->setAction($action);
        }




        /**
     * @param string $name
     * @return InputElement
     */
    public function text($name)
    {
		return $this->addElement(new InputElement($name, 'text', 'text'));
    }

    /**
     * @param $name
     * @return InputElement
     */
    public function textarea($name)
    {
        return $this->addElement(new InputElement($name, 'textarea', 'textarea'));
    }

    /**
     * @param $name
     * @return InputElement
     */
    public function integer($name)
    {
        return $this->addElement(new InputElement($name, 'integer', 'integer'));
    }

    /**
     * @param $name
     * @return InputElement
     */
    public function percentage($name)
    {
        return $this->addElement(new InputElement($name, 'percent', 'percentage'));
    }

    /**
     * @param $name
     * @return CheckableElement
     */
    public function select($name)
    {
        return $this->addElement(new CheckableElement($name, 'choice', 'select', array(
                    'multiple' => false,
                    'expanded' => false,
        )));
    }

    /**
     * @param $name
     * @return CheckableElement
     */
    public function multiselect($name)
    {
        return $this->addElement(new CheckableElement($name, 'choice', 'multiselect', array(
			'multiple' => true,
			'expanded' => false,
		)));
    }

    /**
     * @param $name
     * @return CheckableElement
     */
    public function radio($name)
    {
        return $this->addElement(new CheckableElement($name, 'choice', 'radio', array(
			'multiple' => false,
			'expanded' => false,
		)));
    }

    /**
     * @param $name
     * @return CheckableElement
     */
    public function checkbox($name)
    {
        return $this->addElement(new CheckableElement($name, 'choice', 'checkbox', array(
			'multiple' => false,
			'expanded' => true,
		)));
    }

    /**
     * @param $name
     * @return InputElement
     */
    public function submit($name)
    {
        return $this->addElement(new InputElement($name, 'input', 'submit', 'submit'));
    }

    /**
     * @param $name
     * @return ModelElement
     */
    public function modelSelect($name)
    {
        return $this->addElement(new ModelElement($name, 'choice', 'modelSelect', array(
			'multiple' => false,
			'expanded' => false,
		)));
    }

    /**
     * @param $name
     * @return ModelElement
     */
    public function modelRadio($name)
    {
        return $this->addElement(new ModelElement($name, 'choice', 'modelRadio', array(
			'multiple' => true,
			'expanded' => true,
		)));
    }

    /**
     * @param $name
     * @return ModelElement
     */
    public function modelCheckbox($name)
    {
        return $this->addElement(new ModelElement($name, 'choice', 'modelCheckbox', array(
			'multiple' => true,
			'expanded' => false,
		)));
    }

}
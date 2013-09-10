<?php

use Symfony\Component\Form\FormInterface;

/**
 * 
 * Render the total form, just to quickly render a working form
 *
 */
Form::macro('render', function(FormInterface $form, Model $model = null) {

	$view = $form->createView();

        $options = array();
	$options = array(
		'url' => $view->vars['action'],
		'class' => 'form-horizontal',
	);

	if($model) {
		$html = Form::model($model, $options);
	}
	else {
		$html = Form::open($options);
	}

	$html .= Form::renderFields($form);
	$html .= Form::submit('Save', array('class' => 'btn btn-default'));
	$html .= Form::close();

	return $html;
});

/**
 * 
 * Render only the dynamically generated form fields. 
 * 
 * You have to manually add the Form::open() and Form::close() methods 
 * and add a submit button.
 * 
 */
Form::macro('renderFields', function(FormInterface $form, $errors = null) {

	$html = '';
	
	foreach($form->all() as $child) {
		$html .= Form::formRow($child, $errors);
	}
	
	return $html;
});

/**
 * 
 * Render a single form field
 *
 * It converts the Symfony field elements to Laravel Form ones.
 * 
 */
Form::macro('formRow', function(FormInterface $form, $errors = null) {

	$html = '';
	$view = $form->createView();
	$vars = $view->vars;
	$type = $form->getConfig()->getType()->getInnerType()->getName();
	$name = $vars['name'];
	$label = $vars['label'] ?: $name;
    $value = $vars['data'];
	$attr = $vars['attr'];

	$formLabel = Form::label($name, $label);

	switch($type) {

		case 'integer':
		case 'percent':
		case 'text':
			$formElement = Form::text($name, $value, $attr);
			break;

		case 'textarea':
			$formElement = Form::textarea($name, $value, $attr);
			break;

		case 'choice':

			$choices = array();
			foreach($vars['choices'] as $choice) {
				$choices[$choice->value] = $choice->label;
			}

			if($vars['expanded']) {

				if($vars['multiple']) {
					$formElement = Form::multiRadio($name, $choices, $value, $attr);
				}
				else {
					$formElement = Form::checkbox($name, 1, $value, $attr);
				}

			}
			else {

				if($vars['multiple']) {
					$formElement = Form::multiCheckbox($name, $choices, $value, $attr);
				}
				else {
					$formElement = Form::select($name, $choices, $value, $attr);
				}

			}
			break;

		default: return;
	}

	$error = $errors ? $errors->first($name, '<span class="error">:message</span>') : '';

	return sprintf('<div class="form-group">%s%s%s</div>', $formLabel, $formElement, $error);
});


/**
 * 
 * A convenience macro to build bundled checkboxes
 *
 */
Form::macro('multiCheckbox', function ($name, $multiOptions, Array $defaults = null) {

	$name .= '[]';
	$inputs = array();

	foreach ($multiOptions as $key => $value) {

		$default = is_array($defaults) && in_array($key, $defaults) ? $key : null;

		$inputName = sprintf('%s[%s]', $name, $key);
		$inputs[]  =
			Form::checkbox($name, $key, $default, array(
				'id' => $inputName,
			)) .
			Form::label($inputName, $value);
	}

	return implode('<br>', $inputs);
});


/**
 * 
 * A convenience method to build bundled radio buttons
 *
 */
Form::macro('multiRadio', function ($name, $multiOptions, Array $defaults = null) {

	$inputs = array();

	foreach ($multiOptions as $key => $value) {
		$inputName = sprintf('%s_%s', $name, $key);
		$inputs[]  =
			Form::radio($name, $key, null, array(
				'id' => $inputName,
			)) .
			Form::label($inputName, $value);
	}

	return implode('<br>', $inputs);
});

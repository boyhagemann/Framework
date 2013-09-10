<?php

namespace Boyhagemann\Text\Controller;

use Boyhagemann\Form\FormBuilder;

class TextController extends \BaseController
{
	public function text($text)
	{
		return $text;
	}

	public function textPortlet(FormBuilder $fb)
	{
		$fb->textarea('text')->label('Text')->required();
	}
}


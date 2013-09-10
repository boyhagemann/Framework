<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Crud\CrudController;
use Boyhagemann\Form\FormBuilder;
use Boyhagemann\Model\ModelBuilder;
use Boyhagemann\Overview\OverviewBuilder;

class LayoutController extends CrudController
{
	/**
     * @param FormBuilder $fb
     */
    public function buildForm(FormBuilder $fb)
    {
        $fb->text('title')->label('Title');
        $fb->text('name')->label('Name');
    }

    /**
     * @param ModelBuilder $mb
     */
    public function buildModel(ModelBuilder $mb)
    {
        $mb->name('Boyhagemann\Pages\Model\Layout')->table('layouts');
        $mb->hasMany('Boyhagemann\Pages\Model\Section')->alias('sections');
    }

    /**
     * @param OverviewBuilder $ob
     */
    public function buildOverview(OverviewBuilder $ob)
    {
        $ob->fields(array('title'));
    }

	/**
	 * @return array
	 */
	public function config()
	{
		return array(
			'title' => 'Layout',
			'redirects' => array(
				'test'
			)
		);
	}


}

//
<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Crud\CrudController;
use Boyhagemann\Form\FormBuilder;
use Boyhagemann\Model\ModelBuilder;
use Boyhagemann\Overview\OverviewBuilder;

class SectionController extends CrudController
{
	/**
     * @param FormBuilder $fb
     */
    public function buildForm(FormBuilder $fb)
    {
        $fb->text('title')->label('Title');
        $fb->text('name')->label('Name');
        $fb->modelSelect('layout_id')->label('Layout')->model('Boyhagemann\Pages\Model\Layout');
    }

    /**
     * @param ModelBuilder $mb
     */
    public function buildModel(ModelBuilder $mb)
    {
        $mb->name('Boyhagemann\Pages\Model\Section')->table('sections');
    }

    /**
     * @param OverviewBuilder $ob
     */
    public function buildOverview(OverviewBuilder $ob)
    {
        $ob->fields(array('title', 'name', 'layout_id'));
    }

	/**
	 * @return array
	 */
	public function config()
	{
		return array(
			'title' => 'Section',
		);
	}

}


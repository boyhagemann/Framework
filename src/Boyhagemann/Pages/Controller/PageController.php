<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Crud\CrudController;
use Boyhagemann\Form\FormBuilder;
use Boyhagemann\Model\ModelBuilder;
use Boyhagemann\Overview\OverviewBuilder;
use Boyhagemann\Pages\Model\Page;
use Boyhagemann\Pages\Model\Section;
use Boyhagemann\Pages\Model\Block;
use DB, App, View, Input, Config, Redirect;

class PageController extends CrudController
{
	/**
	 * @param Page $page
	 * @return mixed
	 */
	public function content(Page $page)
	{
		$sections = $page->layout->sections;
		$blocks = Block::all();

		return View::make('pages::page.content', compact('page', 'sections', 'blocks'));
	}

	/**
	 * @param Page  $page
         * @param Section $section
	 * @param Block $block
	 * @return mixed
	 */
	public function addContent(Page $page, Section $section, Block $block)
	{
		list($controller, $action) = explode('@', $block->controller);

		$controller = App::make($controller);
		$portlet = $action . 'Portlet';
		$fb = new FormBuilder;

		if(method_exists($controller, $portlet)) {
                    $controller->$portlet($fb);
		}

		$form = $fb->build();

		return View::make('pages::page.add-content', compact('form', 'page', 'section', 'block'));
	}

	/**
	 * @param Page  $page
         * @param Section $section
	 * @param Block $block
	 * @return mixed
	 */
	public function storeContent(Page $page, Section $section, Block $block)
	{
		$controller = App::make('Boyhagemann\Pages\Controller\ContentController');
		Config::set('crud::redirects.success.store', 'admin.pages.index');
		Config::set('crud::redirects.error.store', 'admin.pages.content.create');

		Input::replace(array(
			'params' => Input::all(),
			'page_id' => $page->id,
			'block_id' => $block->id,
			'section_id' => $section->id,
		));

		$controller->store();
                
                return Redirect::route('admin.pages.content', $page->id);
	}

    /**
     * @param FormBuilder $fb
     */
    public function buildForm(FormBuilder $fb)
    {
        $fb->text('title')->label('Title');
        $fb->text('route')->label('Route');
        $fb->modelSelect('layout_id')->alias('layout')->label('Layout')->model('Boyhagemann\Pages\Model\Layout');
		$fb->select('method')->label('Method')->choices(array('get' => 'GET', 'post' => 'POST', 'put' => 'PUT', 'patch' => 'PATCH', 'delete' => 'DELETE'))->value('get');
    }

    /**
     * @param ModelBuilder $mb
     */
    public function buildModel(ModelBuilder $mb)
    {
        $mb->name('Boyhagemann\Pages\Model\Page')->table('pages')->presenter('PagePresenter');
    }

    /**
     * @param OverviewBuilder $ob
     */
    public function buildOverview(OverviewBuilder $ob)
    {
        $ob->fields(array('title', 'route', 'layout_id'));
    }

	/**
	 * @return array
	 */
	public function config()
	{
		return array(
			'title' => 'Page',
			'view' => array(
//				'create' => 'crud::crud.create',
				'edit' => 'pages::page.edit',
				'index' => 'pages::page.index',
			),
                        'redirects.success.store' => 'pages::page.content'
		);
	}

}


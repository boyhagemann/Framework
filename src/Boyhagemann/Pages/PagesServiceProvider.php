<?php

namespace Boyhagemann\Pages;

use Illuminate\Support\ServiceProvider;
use Route, App, Config, Schema;

class PagesServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->package('pages', 'pages');
        
        $this->app->register('Boyhagemann\Crud\CrudServiceProvider');
        $this->app->register('Boyhagemann\Blocks\BlocksServiceProvider');
        $this->app->register('Boyhagemann\Text\TextServiceProvider');

		$this->app['view']->addNamespace('pages', __DIR__.'/views');
    }
    
    public function boot()
    {
		Route::model('page', 'Boyhagemann\Pages\Model\Page');
		Route::model('section', 'Boyhagemann\Pages\Model\Section');
		Route::model('block', 'Boyhagemann\Pages\Model\Block');

        Route::get('admin/pages/{page}/content', array(
            'uses'  => 'Boyhagemann\Pages\Controller\PageController@content',
            'as'    => 'admin.pages.content'
        ));
		Route::get('admin/pages/{page}/content/create/{section}/{block}', array(
			'uses'  => 'Boyhagemann\Pages\Controller\PageController@addContent',
			'as'    => 'admin.pages.content.create'
		));
		Route::post('admin/pages/{page}/content/store/{section}/{block}', array(
			'uses'  => 'Boyhagemann\Pages\Controller\PageController@storeContent',
			'as'    => 'admin.pages.content.store'
		));

        Route::resource('admin/layouts', 'Boyhagemann\Pages\Controller\LayoutController');
        Route::resource('admin/pages', 'Boyhagemann\Pages\Controller\PageController');
        Route::resource('admin/blocks', 'Boyhagemann\Pages\Controller\BlockController');
        Route::resource('admin/sections', 'Boyhagemann\Pages\Controller\SectionController');
        Route::resource('admin/content', 'Boyhagemann\Pages\Controller\ContentController');

		if(Schema::hasTable('pages')) {
			Config::set('blocks', App::make('Boyhagemann\Pages\Model\Page')->getBlocks());

			$routes = array();
			foreach(Route::getRoutes() as $path => $route) {
				$routes[$path] = $route;
			}

			foreach(Model\Page::get() as $page) {
				if($page->method != 'get' || isset($routes[$page->route])) {
					continue;
				}
				$method = $page->method;
				Route::$method($page->route, function() {});
			}
		}
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
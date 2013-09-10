<?php

namespace Boyhagemann\Navigation\Controller;

use Boyhagemann\Navigation\Model\Node;
use Config, App;

class MenuController extends \BaseController
{
    protected $menu;
    
    public function admin()
    {
        $menu = App::make('Menu\Menu');
        $this->menu = $menu->handler('admin', array('class' => 'nav navbar-nav'));
        
        $nodes = Node::whereDepth(0)->whereContainerId(1)->with('page')->get();

        foreach($nodes as $node) {
            $this->buildMenu($node);
        }
        
        return $this->menu->render();
    }
    
    public function buildMenu($node)
    {
        $linkAttribs = array();
        $listAttribs = array();
        $title = $node->title;
        $sub = null;
        
        if($node->children->count()) {
            $sub = App::make('Menu\Menu')->items('test', array('class' => 'dropdown-menu'));
            foreach($node->children as $child) {

                if($child->page) {
                    $sub->add(url($child->page->route), $child->title);
                }
                else {
                    $sub->add('', $child->title);
                }
            }
            $title = $node->title .= ' <b class="caret"></b>';
            $linkAttribs = array(
                'class' => 'dropdown-toggle',
                'data-toggle' => 'dropdown',
            );
            $listAttribs = array(
                'class' => 'dropdown',
            );
        }
        
        if($node->page) {
            $this->menu->add(url($node->page->route), $title, $sub, $linkAttribs, $listAttribs);
        }
        else {
            $this->menu->add('', $title, $sub, $linkAttribs, $listAttribs);
        }
    }

}
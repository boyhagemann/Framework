<?php

namespace Boyhagemann\Navigation\Model;

class Node extends \Baum\Node
{

    protected $table = 'navigation_node';

    public $timestamps = false;

    public $rules = array();

    protected $guarded = array('id');

    protected $fillable = array(
        'title',
        'route',
        'container_id',
		'page_id',
        );

    /**
     * @return Container
     */
    public function container()
    {
        return $this->belongsTo('Boyhagemann\Navigation\Model\Container');
    }

	/**
	 * @return \Boyhagemann\Pages\Model\Page
	 */
	public function page()
	{
		return $this->belongsTo('Boyhagemann\Pages\Model\Page');
	}

}


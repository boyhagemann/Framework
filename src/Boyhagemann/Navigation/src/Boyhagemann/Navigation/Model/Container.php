<?php

namespace Boyhagemann\Navigation\Model;

class Container extends \Eloquent
{

    protected $table = 'navigation_container';

    public $timestamps = false;

    public $rules = array();

    protected $guarded = array('id');

    protected $fillable = array(
        'title',
        'name'
        );


}


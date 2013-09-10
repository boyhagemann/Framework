<?php

namespace Boyhagemann\Pages\Model;

class Block extends \Eloquent
{

    protected $table = 'blocks';

    public $timestamps = false;

    public $rules = array();

    protected $guarded = array('id');

    protected $fillable = array(
        'title',
        'controller'
        );


}


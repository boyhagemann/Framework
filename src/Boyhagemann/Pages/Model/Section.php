<?php

namespace Boyhagemann\Pages\Model;

class Section extends \Eloquent
{

    protected $table = 'sections';

    public $timestamps = false;

    public $rules = array();

    protected $guarded = array('id');

    protected $fillable = array(
        'title',
        'name',
        'layout_id'
        );

    /**
     * @return \Pages\Layout
     */
    public function layout_id()
    {
        return $this->belongsTo('Pages\Layout');
    }


}


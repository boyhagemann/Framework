<?php

namespace Boyhagemann\Pages\Model;

class Layout extends \Eloquent
{

    protected $table = 'layouts';

    public $timestamps = false;

    public $rules = array();

    protected $guarded = array('id');

    protected $fillable = array(
        'title',
        'name'
        );

    /**
     * @return \Boyhagemann\Pages\Model\Section
     */
    public function sections()
    {
        return $this->hasMany('Boyhagemann\Pages\Model\Section');
    }

	/**
	 * @return \Boyhagemann\Pages\Model\Page
	 */
	public function pages()
	{
		return $this->hasMany('Boyhagemann\Pages\Model\Page');
	}


}


<?php

namespace Boyhagemann\Form\Element;

use App;

class ModelElement extends CheckableElement
{
    /**
     * @var string|\Illuminate\Database\Eloquent\Model
     */
    protected $model;
    protected $key;
    protected $field;
    protected $alias;
    protected $blank;
    protected $callback;

	/**
	 * @return array
	 */
	public function toArray()
	{
		$model = $this->model;
		if(is_object($model)) {
			$model = get_class($model);
		}

		return parent::toArray() + array(
			'model' => $model,
            'alias' => $this>alias,
			'key' => $this->key,
			'field' => $this->field,
			'blank' => $this->blank,
		);
	}

    /**
     * 
     * @param mixed $value
     * @return $this
     */
    public function value($value)
    {        
        if (is_array($value)) {
            $checked = array();
            $key = $this->key ? $this->key : 'id';
            foreach ($value as $data) {
                $checked[] = $data[$key];
            }
            return parent::value($checked);
        }
        else {
            return parent::value($value);
        }
    }

    /**
     * @param $model
     * @return $this
     */
    public function model($model)
    {
        $this->model = $model;
        return $this;
    }
    
    /**
     * 
     * @return string|Model

     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $key
     * @return $this
     */
    public function key($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function field($field)
    {
        $this->field = $field;
        return $this;
    }
    
    /**
     * @param $alias
     * @return $this
     */
    public function alias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

	/**
	 * @param $blank
	 * @return $this
	 */
	public function blank($blank)
	{
		$this->blank = $blank;
		return $this;
	}
    
    /**
     * 
     * @return string
     */
    public function getAlias()
    {
        if(!$this->alias) {
            return $this->name;
        }
        
        return $this->alias;
    }

    /**
     * @param Closure $callback
     */
    public function query(Closure $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        if (!$this->hasOption('choices')) {
            $this->options['choices'] = $this->buildChoices();
        }

        return parent::getOptions();
    }

    protected function buildChoices()
    {
		if(!$this->model) {
			return;
		}

        if (is_string($this->model)) {
            $this->model = App::make($this->model);
        }

        $q = $this->model->query();

        if ($this->callback) {
            $this->callback($q);
        }

        $key = $this->key ? $this->key : 'id';
        $field = $this->field ? $this->field : "title";


		$choices = $this->blank ? array('' => $this->blank) : array();
		$choices += $q->lists($field, $key);

		return $choices;
    }

    /**
     * 
     * @param string $name
     * @return bool
     */
    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }

    /**
     * 
     * @param string $name
     * @return mixed
     */
    public function getOption($name)
    {
        if (!$this->hasOption($name)) {
            return;
        }

        return $this->options[$name];
    }

}
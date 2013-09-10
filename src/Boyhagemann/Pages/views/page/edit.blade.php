<div class="page-header">
<h1>
	Page <small>{{ $model->title }}</small>
	<small class="pull-right"><a href="{{ URL::route($route . '.index') }}" class="btn-primary btn">Overview</a></small>
</h1>
</div>

<ul class="nav nav-pills">
	<li class="active"><a href="{{ URL::route('admin.pages.edit', $model->id) }}">Properties</a></li>
	<li><a href="{{ URL::route('admin.pages.content', $model->id) }}">Content</a></li>
</ul>
<br>

<div class="col-lg-12">

{{ Form::model($model, array('route' => array($route . '.update', $model->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
{{ Form::renderFields($form, $errors) }}
{{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
{{ Form::close() }}

</div>

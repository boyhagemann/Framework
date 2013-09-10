<div class="page-header">
	<h1>
		@if($title)
		{{{ $title }}} <small>Create</small>
		@else
		Create
		@endif
		<small class="pull-right"><a href="{{ URL::route($route . '.index') }}" class="btn-primary btn">Overview</a></small>
	</h1>
</div>

<ul class="nav nav-pills">
	<li class="active"><a href="{{ URL::route('pages::page.edit') }}">Properties</a></li>
	<li class="disabled"><a href="">Content</a></li>
</ul>
<br>

<div class="col-lg-12">

{{ Form::model($model, array('route' => $route . '.store', 'class' => 'form-horizontal')) }}
{{ Form::renderFields($form, $errors) }}
{{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
{{ Form::close() }}

</div>
<div class="page-header">
	<h1>Pages <small>Overview</small>
	<small class="pull-right"><a href="{{ URL::route($route . '.create') }}" class="btn-primary btn">Create</a></small>
	</h1>
</div>

<table class="table table-striped">
	<tr>
		<thead>
		@foreach($overview->labels() as $label)
		<th>{{ $label }}</th>
		@endforeach
		<th></th>
		</thead>
	</tr>
	<tbody>
	@foreach($overview->rows() as $id => $row)
	<tr>
		@foreach($row->columns() as $column)
		<td>{{ $column }}</td>
		@endforeach
		<td class="col-3">
			{{ Form::open(array('route' => array($route . '.destroy', $id), 'method' => 'DELETE')) }}
			<a href="{{ URL::route($route . '.edit', $id) }}" class="btn btn-xs btn-default">Properties</a>
			<a href="{{ URL::route('admin.pages.content', $id) }}" class="btn btn-xs btn-default">Content</a>
			{{ Form::submit('Delete', array('class' => 'btn btn-xs btn-link')) }}
			{{ Form::close() }}
		</td>
	</tr>
	@endforeach
	</tbody>
</table>

{{ $overview->links() }}


@foreach($containers as $container)

	<h1>{{ $container['title'] }}</h1>
	<ul class="list-unstyled row">
	@foreach($container['tree'] as $node)
	<li class="col-lg-offset-{{ $node->depth }}">
		@if($node->page)
		<a href="{{ URL::route('admin.pages.content', $node->page->id) }}">{{ $node->title }}</a>
		@else
		{{ $node->title }}
		@endif
	</li>
	@endforeach
	</ul>

@endforeach

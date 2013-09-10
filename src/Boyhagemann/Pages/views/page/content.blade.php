<div class="page-header">
	<h1>
		Page <small>{{ $page->title }}</small>
		<small class="pull-right"><a href="{{ URL::route('admin.pages.index') }}" class="btn-primary btn">Overview</a></small>
	</h1>
</div>

<ul class="nav nav-pills">
	<li><a href="{{ URL::route('admin.pages.edit', $page->id) }}">Properties</a></li>
	<li class="active"><a href="{{ URL::route('admin.pages.content', $page->id) }}">Content</a></li>
</ul>
<br>

<div class="col-lg-12">

	@foreach($sections as $section)
	<section class="">
		<header class="row">
			<h2 class="pull-left">{{ $section->title }}</h2>
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown">Add block <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @foreach($blocks as $block)
                                    <li><a href="{{ URL::route('admin.pages.content.create', array($page->id, $section->id, $block->id)) }}">{{ $block->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
		</header>
		<ul class="list-unstyled">
			@if(isset($page->blocks[$section->id]))
			@foreach($page->blocks[$section->id] as $block)
			<li class="well well-sm">
				<h4>{{ $block->title }}</h4>
			</li>
			@endforeach
			@endif
		</ul>
	</section>
	@endforeach
</div>
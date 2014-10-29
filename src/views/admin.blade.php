@extends('admin.template')

@section('content')

	<h3 class="pull-left">Projects</h3>

	<div class=""> 

		<a href="{{ url('admin/portfolio/create') }}" class="btn btn-lg btn-success pull-right">
			Create new project
		</a>

		<div class="clearfix"></div>
		@if(count($projects))

		<table class="table table-striped">
			<thead>
				<th>#</th>
				<th>Name</th>
				<th></th>
				<th></th>
				<th>up</th>
				<th>down</th>
			</thead>
			<tbody>
				@foreach($portfolio as $k => $project)
				<tr>
					<td>{{ $project->id }}</td>
					<td>{{ $project->name }}</td>
					<td>
						<a href="{{ url('admin/portfolio/' . $project->id . '/edit') }}" class="btn btn-sm btn-primary">edit</a>
					</td>
					<td>
						<a href="{{ url('admin/portfolio/' . $project->id . '/delete') }}" class="btn btn-sm btn-danger">delete</a>
					</td>
					<td>
						@if($k-1 >= 0)
						{!! Form::open(['url' => 'admin/portfolio/swap']) !!}

							{!! Form::hidden('id1', $portfolio[$k-1]->id) !!}
							{!! Form::hidden('id2', $project->id) !!}

							{!! Form::submit('move up', [ 'class' => 'btn-sm btn btn-success']) !!}

						{!! Form::close() !!}
						@endif
					</td>
					<td>
						@if($k+1 < count($projectenu))
						{!! Form::open(['url' => 'admin/portfolio/swap']) !!}

							{!! Form::hidden('id1', $project->id) !!}
							{!! Form::hidden('id2', $portfolio[$k+1]->id) !!}

							{!! Form::submit('move down', [ 'class' => 'btn-sm btn btn-success']) !!}

						{!! Form::close() !!}
						@endif

					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
			<p class="text-muted">No projects found.</p>
		@endif

	</div>

@stop
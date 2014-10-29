@extends('admin.template')

@section('content')

	<h3 class="pull-left">Edit project</h3>

	<div class=""> 

		{!! Form::open([ 'url' => 'admin/portfolio/' . $project->slug . '/edit']) !!}

			{!! Form::submit('Edit project', [ 'class' => 'btn btn-lg btn-primary pull-right']) !!}

			<div class="clearfix"></div>

			<h3>{!! Form::label('name', 'Name') !!}</h3>
			{!! Form::text('name', $project->name, [ 'class' => 'form-control' ]) !!}

			<h3>{!! Form::label('description', 'Project description') !!}</h3>
			{!! Form::textarea('description', $project->description, [ 'class' => 'form-control', 'rows' => 10 ]) !!}

		{!! Form::close() !!}

	</div>

@stop
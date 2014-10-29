@extends('admin.template')

@section('content')

	<h3 class="pull-left">Create project</h3>

	<div class=""> 

		{!! Form::open([ 'url' => 'admin/portfolio/create']) !!}

			{!! Form::submit('Create project', [ 'class' => 'btn btn-lg btn-primary pull-right']) !!}

			<div class="clearfix"></div>

			<h3>{!! Form::label('name', 'Name') !!}</h3>
			{!! Form::text('name', '', [ 'class' => 'form-control' ]) !!}

			<h3>{!! Form::label('description', 'Project description') !!}</h3>
			{!! Form::textarea('description', '', [ 'class' => 'form-control', 'rows' => 10 ]) !!}

		{!! Form::close() !!}

	</div>

@stop
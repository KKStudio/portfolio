@extends('admin.template')

@section('content')

	<h3 class="pull-left">Edytuj projekt</h3>

	<div class=""> 

		{!! Form::open([ 'url' => 'admin/portfolio/' . $project->slug . '/edit', 'files' => 'true']) !!}

			{!! Form::submit('Zapisz zmiany', [ 'class' => 'btn btn-lg btn-primary pull-right']) !!}

			<div class="clearfix"></div>

			<div class="fileinput fileinput-new" data-provides="fileinput">
			  <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
			  	<img src="{{ $project->getThumb() }}">
			  </div>
			  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
			  <div>
			    <span class="btn btn-default btn-file">
				    <span class="fileinput-new">Wybierz zdjęcie</span>
				    <span class="fileinput-exists">Zmień</span>		    
				    {!! Form::file('image', [ 'class' => 'form-control' ]) !!}
				    </span>
			    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Usuń</a>
			  </div>
			</div>

			<h3>{!! Form::label('name', 'Nazwa') !!}</h3>
			{!! Form::text('name', $project->name, [ 'class' => 'form-control' ]) !!}

			<h3>{!! Form::label('description', 'Opis projektu') !!}</h3>
			{!! Form::textarea('description', $project->description, [ 'class' => 'editor form-control', 'rows' => 10 ]) !!}

		{!! Form::close() !!}

	</div>

@stop
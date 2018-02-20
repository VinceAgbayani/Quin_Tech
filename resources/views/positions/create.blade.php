@extends('templates.dashboard-master')

@section('body')
	<main class="container create-page">
		<section class="row crud-page-top">
			<h1 class="crud-page-title">Add Position</h1>
		</section>
		<section>
			<!-- if there are creation errors, they will show here -->
			{{ Html::ul($errors->all()) }}

			{{ Form::open(array('url' => 'positions')) }}
				<div class="form-group">
				    {{ Form::label('name', 'Positon Name') }}
				    {{ Form::text('name', Request::old('name'), array('class' => 'form-control', 'autofocus')) }}
				</div>
			   	<div class="form-group text-center create-bottom-wrapper">
			   		<a href="{{ URL::to('positions') }}" class="btn cancel-btn">Cancel</a>
			   		 {{ Form::submit('Create position', array('class' => 'btn btn-primary create-btn text-center')) }}
			   	</div>

			{{ Form::close() }}
		</section>
	</main>


@endsection
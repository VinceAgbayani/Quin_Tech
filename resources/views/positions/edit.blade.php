@extends('templates.dashboard-master')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var a = document.getElementById('positions');
        a.classList.toggle("active");
    });

    // enables Bootstrap tooltips
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });

</script>

@section('body')

	<main class="container create-page">
		<section class="row crud-page-top">
            <h1 class="crud-page-title">Edit Position</h1>
        </section>
        <section>
        	{{ Html::ul($errors->all()) }}

			{{ Form::model($position, 
			array('route' => array('positions.update', $position->id), 'method' => 'PUT')) }}

				
			    <div class="form-group">
			        {{ Form::label('name', 'Position Name') }}
			        {{ Form::text('name', Request::old('name'), array('class' => 'form-control', 'autofocus')) }}
			    </div>

			    <div class="form-group">
				    {{ Form::label('knowledge_based_weight', 'Knowledge-Based Weight') }}
				    {{ Form::text('knowledge_based_weight', Request::old('knowledge_based_weight'), array('class' => 'form-control', 'autofocus')) }}
				</div>
				<div class="form-group">
				    {{ Form::label('skills_based_weight', 'Skills-Based Weight') }}
				    {{ Form::text('skills_based_weight', Request::old('skills_based_weight'), array('class' => 'form-control', 'autofocus')) }}
				</div>

				<div class="form-group text-center create-bottom-wrapper">
					<a href="{{ URL::to('positions') }}" class="btn cancel-btn">Cancel</a>
                    {{ Form::submit('Save changes', array('class' => 'btn btn-primary create-btn text-center')) }}
				</div>  

			    <!-- {{ Form::submit('Edit Position', array('class' => 'btn btn-primary')) }} -->

			{{ Form::close() }}
        </section>
	</main>




@endsection
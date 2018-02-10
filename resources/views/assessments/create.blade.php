@extends('templates.newsletter-master')

@section('body')

<h1>Create a Assessment</h1>

<!-- if there are creation errors, they will show here -->
{{ Html::ul($errors->all()) }}

{{ Form::open(array('url' => 'assessments')) }}

    <div class="form-group">
        {{ Form::label('topic', 'Topic') }}
        {{ Form::text('topic', Request::old('topic'), array('class' => 'form-control')) }}
    </div>

    {{ Form::submit('Create the Assessment!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

</div>
@endsection


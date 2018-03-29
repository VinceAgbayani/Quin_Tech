@extends('templates.dashboard-master')

@section('body')
    
    <main class="container create-page">
        <section class="row crud-page-top">
            <h1 class="crud-page-title">Create Training Session</h1>
            <a href="{{ URL::to('trainings') }}" class="btn cancel-btn">Back to All Trainings</a>
        </section>
        <section>
            <!-- if there are creation errors, they will show here -->
            @if (Session::has('errors'))
                <div class="alert alert-warning" role="alert">
                    <strong>Warning</strong>
                    {{ Html::ul($errors->all()) }}
                </div>
            @endif

            {{ Form::open(array('url' => 'trainings')) }}
                
                <div class="form-group">
                    {{ Form::label('title', 'Title') }}
                    {{ Form::text('title', Request::old('title'), array('class' => 'form-control', 'autofocus')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('date', 'Date') }}
                    {{ Form::date('date', Request::old('date'), array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('starting_time', 'Starting Time') }}
                    {{ Form::time('starting_time', Request::old('starting_time'), array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('ending_time', 'Ending Time') }}
                    {{ Form::time('ending_time', Request::old('ending_time'), array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('speaker', 'Speaker') }}
                    {{ Form::text('speaker', Request::old('speaker'), array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('venue', 'Venue') }}
                    {{ Form::text('venue', Request::old('venue'), array('class' => 'form-control')) }}
                </div>

                <div class="form-group text-center create-bottom-wrapper">
                    <a href="{{ URL::to('trainings') }}" class="btn cancel-btn">Cancel</a>
                    {{ Form::submit('Create Training Session', array('class' => 'btn btn-primary create-btn text-center')) }}
                </div>
                
            {{ Form::close() }}
            
        </section>
    </main>

@endsection

<script type="text/javascript">
    $(document).ready(function() {
        var a = document.getElementById('training-sessions');
        a.classList.toggle("active");
    });

    // enables Bootstrap tooltips
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });

</script>
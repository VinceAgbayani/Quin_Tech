@extends('templates.dashboard-master')

@section('body')

    <main class="container create-page">
        <section class="row crud-page-top">
            <div>
                <h1 class="crud-page-title">Edit Training Session</h1>
            </div>
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

            {{ Form::model($training, 
            array('route' => array('trainings.update', $training->id), 'method' => 'PUT')) }}

                <div class="form-group">
                    {{ Form::label('title', 'Title') }}
                    {{ Form::text('title', Request::old('title'), array('class' => 'form-control', 'autofocus', 'pattern' => '[a-zA-z ]+', 'required', 'title' => 'Please use alphabet characters only')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('date', 'Date (dd/mm/yy)') }}
                    {{ Form::date('date', Request::old('date'), array('class' => 'form-control', 'required', 'min' => '2000-01-01', 'id' => 'date')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('starting_time', 'Starting Time') }}
                    {{ Form::time('starting_time', Request::old('starting_time'), array('class' => 'form-control', 'required')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('ending_time', 'Ending Time') }}
                    {{ Form::time('ending_time', Request::old('ending_time'), array('class' => 'form-control', 'required')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('speaker', 'Speaker') }}
                    {{ Form::text('speaker', Request::old('speaker'), array('class' => 'form-control', 'pattern' => '[a-zA-z ]+', 'required', 'title' => 'Please use alphabet characters only')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('venue', 'Venue') }}
                    {{ Form::text('venue', Request::old('venue'), array('class' => 'form-control', 'required')) }}
                </div>

                <div class="form-group text-center create-bottom-wrapper">
                    <a href="{{ URL::to('trainings') }}" class="btn cancel-btn">Cancel</a>
                    {{ Form::submit('Edit Training Session', array('class' => 'btn btn-primary create-btn text-center')) }}
                </div>
                
            {{ Form::close() }}
        </section>
    </main>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var a = document.getElementById('training-sessions');
        a.classList.toggle("active");

        var now = new Date();
        now.setDate(now.getDate() + 1);

        var today = now.toISOString().substring(0,10);

        document.getElementById("date").setAttribute("min", today);
    });

    // enables Bootstrap tooltips
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });

</script>
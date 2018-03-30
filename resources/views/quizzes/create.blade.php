@extends('templates.dashboard-master')

@section('body')
  <main class="container create-page">
      <section class="crud-page-top">
          <h1 class="crud-page-title">Add Quiz</h1>
          <a href="{{ URL::to('quizzes') }}" class="btn cancel-btn">Back to All Quizzes</a>
      </section>
      <hr>
      <section>
          <!-- if there are creation errors, they will show here -->
          @if (Session::has('errors'))
              <div class="alert alert-warning" role="alert">
                  <strong>Warning</strong>
                  {{ Html::ul($errors->all()) }}
              </div>
          @endif

          {{ Form::open(array('url' => 'quizzes')) }}

              <div class="form-group">
                  {{ Form::label('topic', 'Topic') }}
                  {{ Form::text('topic', Request::old('topic'), array('class' => 'form-control', 'required')) }}
              </div>

              <div class="form-group">
                      {{ Form::label('password', 'Password') }}
                      {{ Form::text('password', Request::old('password'), array('class' => 'form-control', 'required')) }}
                  </div>

                  {{ Form::label('training', 'Training') }}
                    <select id="training_id" class="form-control" name="training_id">
                      @foreach($trainings as $key => $value)
                        <option value="<?php echo $value->id ?>">{{$value->title}}</option>
                      @endforeach
                    </select>

               <div class="form-group text-center create-bottom-wrapper">
                  <a href="{{ URL::to('quizzes') }}" class="btn cancel-btn">Cancel</a>
                  {{ Form::submit('Create quiz', array('class' => 'btn btn-primary create-btn text center')) }}
              </div>

          {{ Form::close() }}
        
      </section>
  </main>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var a = document.getElementById('quizzes');
        a.classList.toggle("active");
    });

    // enables Bootstrap tooltips
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });

</script>



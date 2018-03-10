@extends('templates.dashboard-master')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
<br>
<br>
<br>
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
@section('body')
     <main class="container-fluid">
        <section class="container-fluid">
            <h2> Recommend Trainings </h2>
            
            {{ Form::open(array('url' => 'recommend_fire')) }}
            <div class="form-group">
                            {{ Form::label('training', 'Training') }}
                            <select id="training" class="form-control" name="training">
                                @foreach($trainings as $key => $training)
                                    <option value="<?php echo $training->id ?>">
                                        {{$training->title}} 
                                    </option>
                                @endforeach
                            </select>
                        </div>
            <button class="btn crud-main-cta" type="button" data-toggle="modal" <?php echo 'data-target="#'.$training->id.'"'>?>Recommend</button>
        </section>
        <div class="modal fade" <?php echo 'id="'.$training->id.'"'?> tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Recommend</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    

                        <h2> {{$training->title}} </h2>
     
                        <div class="form-group">
        
                            @foreach($users as $key => $user)
                                <?php
                                    $recommended = false;
                                ?>
                                {{ Form::label($user->id, $user->first_name.' '.$user->last_name) }}

                                @foreach($user_trainings as $key => $user_training)
                                    @if(($user_training->training_id == $training->id)and($user_training->user_id==$user->id))
                                        <?php
                                            $recommended = true;
                                        ?>
                                    @endif
                                @endforeach

                                @if($recommended)
                                    <p>Already Recommended</p>
                                @else
                                    {{ Form::checkbox($user->id,$user->id, true) }}
                                <br>
                                @endif
                            @endforeach

                        </div>

                    {{ Form::submit('Recommend', array('class' => 'btn btn-primary create-btn text-center')) }}
                    {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>


    </main>


@endsection
@extends('templates.dashboard-master') 

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ URL::asset('js/dashboard.js') }}"></script>

    <script type="text/javascript">
        // enables dynamic navbar
        $(document).ready(function() {
            var a = document.getElementById('levels');
            a.classList.toggle("active");
        });

        // enables Bootstrap tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@section('body')

    <main class="container-fluid">
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        <?php 
            $current_user = Auth::user();
            $current_id = Auth::user()->id;

            $cup = asset( 'images/profile_photos/'.Auth::user()->profile_photo);
        ?>

        <section class="row personal-details hr-pastel">
            <div class="inner">
                <img class="img-circle profile-picture" src="{{ $cup }}" alt="Your profile picture">
                <div class="user-details">
                     @auth
                    <h1 class="username-title">{{ $current_user ->first_name }} {{ $current_user ->last_name }}</h1>
                    <h6>{{ $current_user->position }}</h6>
                    <h6>{{ $current_user->department }}</h6>
                    <br>
                    <h6>{{ Auth::user()->email }}</h6>
                    @endauth
                </div>
            </div>
        </section>

<!-- data collection -->
        <?php
        $qscore_arr_all = array();
        $labels_arr_all = array();
        $assessments_arr = array();
        $score_data_all = array();
        ?>
        <!-- scores -->
        @foreach($user_quizzes as $key => $value)
            <?php $u_id=$value->id ?>
            @if($value->user_id==$current_id)
                @foreach($section_attempts as $key => $value)
                    @if($value->user_quiz_id==$u_id)
                         <?php
                         $res = ($value->score/$value->max_score)*100;
                         array_push($qscore_arr_all,$res);
                         ?>
                    @endif
                @endforeach
            @endif       
        @endforeach
        <!-- end scores -->
        <!-- labels -->
        @foreach($user_quizzes as $key => $value)
            <?php $u_id=$value->id ?>
            @if($value->user_id==$current_id)
                @foreach($section_attempts as $key => $value)
                    @if($value->user_quiz_id==$u_id)
                    <?php $sc_id = $value->section_id?>
                        @foreach($sections as $key=>$value)
                            @if($sc_id==$value->id)
                            <?php $sk_id = $value->skill_id?>
                                @foreach($skills as $key=>$value)
                                    @if($sk_id==$value->id)
                                        <?php 
                                        array_push($labels_arr_all, $value->name);
                                        ?>
                                    @endif
                                @endforeach
                            @endif 
                        @endforeach
                    @endif
                @endforeach
            @endif       
        @endforeach
        <!-- end labels -->
        <!-- assessments -->
        <?php  ?>
        @foreach($user_assessments as $value)
            @if($value->employee_id==$current_id)
                <?php 
                array_push($assessments_arr, $value->rating);
                echo $value                
                ?>
            @endif
        @endforeach
        <!-- end assessments -->
        <h2>Hello</h2>
        <!-- calculations -->
        <?php 
            print_r($assessments_arr);
        foreach($qscore_arr_all as $value)
        {
                
            if(empty($assessments_arr)==false)
            {
                $comp = (($value*0.5)+(end($assessments_arr)*0.5));
                array_push($score_data_all, $comp);
            }
            else
            {
                $score_data_all = $qscore_arr_all;  
            }
        }            
                    
        ?>
        <!-- end assessments -->
<!-- end of data collection -->


        <section class="container dashboard-container">
            <!-- TAB CONTAINER -->
            <div class="row dashboard-tab-container">
                <button class="btn tablinks" onclick="openTab(event, 'personal')">Personal</button>
                <button class="btn tablinks"  onclick="openTab(event, 'non-personal')">Company-wide</button>
            </div>
            <!-- PERSONAL CONTENT CONTAINER -->
            <div class="row dashboard-body tabcontent" id="personal">
                <div class="col-md-7">
                    <h5 class="dashboard-header">Skills</h5>
                    <div class="dashboard-content">
                        <h6 class="content-header">Personal skills overview</h6>
                        <button onclick="update_data(myChart,relevant)">Relevant Skills</button>
                        <button onclick="update_data(myChart,qscore_arr_all)">All Skills</button>
                        <canvas id="myChart" style="height: 100px !important"></canvas>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
                        <script type="text/javascript">

                            var score_data_all = <?php echo json_encode($score_data_all)?>;
                            var labels_all = <?php echo json_encode($labels_arr_all)?>;



                            function update_data(chart, data) 
                            {
                                chart.data.datasets[0].data = data;
                                chart.update();
                            }


                            Chart.defaults.global.maintainAspectRatio = false;
                            var ctx = document.getElementById("myChart").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'horizontalBar',
                                data: {
                                    labels: labels_all,
                                    datasets: [{
                                        label: 'Relevant Skills',
                                        data: score_data_all,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255,99,132,1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:false
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>
                    </div>
                    <div class="dashboard-content">
                        <h6 class="content-header">Quizzes</h6>
                        <!-- QUIZZES HERE -->
                    </div>
                    <div class="dashboard-content">
                        <h6 class="content-header">Assessments</h6>
                        <!-- ASSESSMENTS HERE -->
                    </div>
                </div>
                <div class="col-md-5">
                    <h5 class="dashboard-header">Trainings</h5>
                    @if(!empty($trainings_personal))
                    <div class="dashboard-content">
                        <div class="recommended-wrapper">
                            <h6 class="content-header dark"><b>Recommended Trainings</b></h6>
                            @foreach($trainings_personal as $key => $training)
                                <div class="trainings-box">
                                    <div>
                                        <!-- text -->
                                        <p>
                                            <b>{{$training->title}}</b>
                                        </p>
                                        <span>
                                            {{date('h:i', strtotime($training->starting_time))}}
                                        </span>
                                        <span>
                                            - {{date('h:i a', strtotime($training->ending_time))}}
                                        </span>
                                        <span>
                                            | {{date('F d', strtotime($training->date))}}
                                        </span>
                                        <p>
                                            {{$training->venue}}
                                        </p>
                                    </div>
                                    <div>
                                        <!-- button -->
                                        @foreach($user_trainings as $key => $user_training)
                                        @if($user_training->training_id == $training->id) 
                                            @if($user_training->confirmed == false)
                                                {{ Form::open(array('url' => 'confirm')) }}
                                                {{ Form::hidden('training_id', $value = $training->id) }}
                                                {{ Form::hidden('user_id', $value = Auth::user()->id) }}
                                                {{ Form::submit('SIGN UP', array('class' => 'btn text-center sign-up-btn light')) }}
                                                {{ Form::close() }}
                                            @else
                                                <span class=" going-state light">&#x2714; I'M GOING</span>
                                            @endif             
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="dashboard-content">
                        <div class="incoming-wrapper">
                            <h6 class="content-header light"><b>Trainings this month</b></h6>
                            @foreach($trainings_general as $key => $training)
                                {{ $present = false }} 
                                <div class="trainings-box">
                                    <div>
                                        <!-- text -->
                                        <p><b>{{$training->title}}</b></p>
                                        <span>
                                            {{date('h:i', strtotime($training->starting_time))}}
                                        </span>
                                        <span>
                                            - {{date('h:i a', strtotime($training->ending_time))}}</span>
                                        <span>
                                            | {{date('F d', strtotime($training->date))}}
                                        </span>
                                        <p>{{$training->venue}}</p>
                                    </div>
                                    <div>
                                        @foreach($user_trainings as $key => $user_training)
                                            @if($user_training->training_id == $training->id) 
                                                <?php
                                                    $present = true 
                                                ?>
                                            @endif
                                        @endforeach
                                        @if($present==false) 
                                            {{ Form::open(array('url' => 'signup')) }}
                                            {{ Form::hidden('user_id', $value = Auth::user()->id) }}
                                            {{ Form::hidden('training_id', $value = $training->id) }}
                                            {{ Form::submit('SIGN UP', array('class' => 'btn text-center sign-up-btn outline')) }}
                                            {{ Form::close() }}
                                        @else
                                            @if($user_training->confirmed == true)
                                                <span class="going-state dark">
                                                    &#x2714; I'M GOING
                                                </span> 
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- NON-PERSONAL CONTENT CONTAINER -->
            <div class="row dashboard-body tabcontent" id="non-personal">
                <div class="col-md-7">
                    <h5 class="dashboard-header">Overall skills statistics</h5>
                    <div class="dashboard-content">
                    </div>
                </div>
                <div class="col-md-5">
                    <h5 class="dashboard-header">Overall training statistics</h5>
                    <div class="dashboard-content">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>Date</td>
                                    <td>Title</td>
                                    <td>Speaker</td>
                                    <td>Venue</td>
                                    <td class="no-stretch">Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($trainings as $key => $value)
                                <tr>
                                    <td>{{ $value->date }}</td>
                                    <td>{{ $value->title }}</td>
                                    <td>{{ $value->speaker }}</td>
                                    <td>{{ $value->venue }}</td>

                                    <!-- we will also add show, edit, and delete buttons -->
                                    <td class="table-actions no-stretch">

                                        <!-- show the employee (uses the show method found at GET /employees/{id} -->
                                        <a class="btn show-btn" data-toggle="tooltip" data-placement="bottom" title="View employee" href="{{ URL::to('users/' . $value->id) }}">
                                            <i class="fa fa-user fa-lg"></i>
                                        </a>

                                        <!-- edit this employee (uses the edit method found at GET /employees/{id}/edit -->
                                        <a class="btn edit-btn" data-toggle="tooltip" data-placement="bottom" title="Edit employee" href="{{ URL::to('users/' . $value->id . '/edit') }}">
                                             <i class="fa fa-pencil fa-lg"></i>
                                        </a>

                                        <!-- delete the employee (uses the destroy method DESTROY /employees/{id} -->
                                        <!-- we will add this later since its a little more complicated than the other two buttons -->
                                            {{ Form::open(array('url' => 'users/' . $value->id, 'class' => 'pull-right')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            <div data-toggle="tooltip" data-placement="bottom" title="Delete employee" data-animation="true">
                                                {{ Form::button('<i class="fa fa-trash-o fa-lg"></i>', array('type' => 'submit', 'class' => 'btn delete-btn')) }}
                                            </div>

                                         {{ Form::close() }}
                                        

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>  
                        <a class="crud-main-cta" href="trainings/create">&#43; Add Training</a> 
                    </div>
                </div>
            </div>

        <p>--------------------------------------------------------</p>

        <h1> Quizzes you ought to take</h1>
        <?php
            $quizzes_to_take = array();
            $user_trainings_taken = array();
            $trainings_taken = array();
        ?>

        @foreach($user_trainings as $key => $user_training)
            @if(($user_training->user_id == $current_id)and($user_training->confirmed == true))
                <?php
                    array_push($user_trainings_taken, $user_training)
                ?>
            @endif
        @endforeach

        @foreach($trainings as $key => $training)
            @foreach($user_trainings_taken as $key => $user_training_taken)
                @if($training->id == $user_training_taken->training_id)
                    <?php
                    array_push($trainings_taken, $training)
                    ?>
                @endif
            @endforeach
        @endforeach

        @foreach($trainings_taken as $key => $training_taken)
            @foreach($quizzes as $key => $quiz)
                @if($training_taken->id == $quiz->training_id)
                    <?php
                        array_push($quizzes_to_take, $quiz)
                    ?>
                @endif
            @endforeach        
        @endforeach


        <div style="border: 1px solid blue;">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>Topic</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
            @foreach($quizzes_to_take as $key => $quiz_to_take)
                <tr>
                    <td>{{ $quiz_to_take->topic }}</td>
                    <td>
                        <?php
                            $taken = false;
                        ?>
                        @foreach($user_quizzes as $key => $user_quiz)
                        <?php
                            if(($user_quiz->user_id==$current_id)and($quiz_to_take->quiz_id==$user_quiz->quiz_id))
                            {
                                $taken = true;
                            }
                        ?>
                        @endforeach
                        @if($taken == false)
                         <!-- 
                            <a class="btn btn-small btn-info" href="{{ URL::to('quizzes/' . $quiz_to_take->quiz_id . '/take') }}">Take this Quiz</a>
                         -->

                         {{ Form::open(array('url' => 'verify_pw')) }}
                         {{ Form::hidden('quiz_id', $value = $quiz_to_take->quiz_id) }}
                        {{ Form::submit('Take this Quiz', array('class' => 'btn btn-primary create-btn text-center')) }}
                        {{ Form::close() }}

                        @else
                        <a class="btn btn-small btn-info" >Already Taken :( Hanap ka nalang ng iba. Sad life bro.</a>
                        @endif

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>

        </section>

    </main>

    <p>------------------------------------ </p>
        <h1> Evaluations to take </h1>

        <?php 
            $evals_to_take = array(); // user trainings where quiz has already been training
            $quizzes_taken_id = array();
            $quizzes_taken = array();

            $training_quiz_taken = array();
            // 1) User Quiz

            // 2) Quiz
            // 3) Training
            // 4) User Training
        ?>

        <!-- Get Quiz IDS 
        -->
        @foreach($user_quizzes as $key => $user_quiz) 
            @if($user_quiz->user_id == $current_id)
            <?php
                array_push($quizzes_taken_id,$user_quiz->quiz_id);
            ?>
            @endif
        @endforeach

        <!-- Get Quizzes
        -->
        

        <!-- error here -->

        @foreach($quizzes_taken_id as $key => $quiz_taken_id) 
            @foreach($quizzes as $key => $quiz) 
                @if($quiz->quiz_id == $quiz_taken_id)
                <?php
                    array_push($quizzes_taken,$quiz);
                ?>
                @endif
            @endforeach
        @endforeach

       

        <!-- Get trainings -->

        @foreach($quizzes_taken as $key => $quiz_taken) 
            @foreach($trainings_taken as $key => $training_taken) 
                @if($quiz_taken->training_id == $training_taken->id)
                <?php
                    array_push($training_quiz_taken,$training_taken);
                    
                ?>
                @endif
            @endforeach
        @endforeach


        <!-- Get trainings -->

        

        @foreach($user_trainings as $key => $user_training) 
            @foreach($training_quiz_taken as $key => $answered) 
                
                @if($user_training->training_id == $answered->id)
                <?php
                    array_push($evals_to_take,$user_training);
                ?>

                @endif
            @endforeach
        @endforeach

        
        <!-- error here -->

        @foreach($evals_to_take as $key => $eval)
            @if($eval->evaluation==null)
            {{ Form::open(array('url' => 'evaluate')) }}
            @foreach($trainings_taken as $key => $training)
                @if($training->id == $eval->training_id)
                    {{$training->title}}
                @endif
            @endforeach            
            {{ Form::hidden('training_id', $value = $eval->training_id) }}
            {{ Form::submit('Provide Feedback', array('class' => 'btn btn-primary create-btn text-center')) }}
            {{ Form::close() }}
            @endif
        @endforeach

        
@endsection
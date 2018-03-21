@extends('templates.dashboard-master') 
<script src="{{ URL::asset('js/dashboard.js') }}"></script>


@section('body')
    <main class="container-fluid">
    <section class="container-fluid">
        <?php 
            $current_user = Auth::user();
            $current_id = Auth::user()->id;
            
        ?>
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        <section class="row personal-details hr-pastel">

        @include('templates.dashboard-profile_photo', ['current_user' => $current_user, 'current_id' => $current_id])
         <section class="container dashboard-container">
            <!-- TAB CONTAINER -->
            <div class="row dashboard-tab-container">
                <button class="btn tablinks" onclick="openTab(event, 'personal')">Personal</button>
                <button class="btn tablinks"  onclick="openTab(event, 'non-personal')">Company-wide</button>
            </div>
            <div class="row dashboard-body tabcontent" id="personal">
                @include('templates.dashboard-skills', ['user_skills' => $user_skills])
                @include('templates.dashboard-trainings')
            </div>
            <H3>HR LANDING</H3>
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

        <?php 
        $evals_to_take = array(); // user trainings where quiz has already been training
        ?>

       
        
        <!--@foreach($evals_to_take as $key => $eval)
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
        @endforeach-->
            </section>

        </section>

    </main>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
</script>

<script type="text/javascript">
    // enables dynamic navbar
    // enables tooltips
    $(document).ready(function() {
        var a = document.getElementById('levels');
        a.classList.toggle("active");
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
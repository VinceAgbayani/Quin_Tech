@extends('templates.dashboard-master') 

<script type="text/javascript">
    
    function openCity(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
    }

</script>

@section('body')

    <main class="container-fluid">
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        <?php 
            $current_user = Auth::user();
            $current_id = Auth::user()->id;
            $trainings = $current_user->training_session_id
        ?>

        <p>HR LANDING</p>
        <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'skills')">My Skills</button>
            <button class="tablinks" onclick="openCity(event, 'trainings')">Trainings</button>
        </div>

        <div id="skills" class="tabcontent">
            <h5>Skills graph here</h5>
        </div>

        <section id="trainings" class="tabcontent container-fluid">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td>Date</td>
                        <td>Description</td>
                        <td>Speaker</td>
                        <td>Venue</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($training_sessions as $key => $value)
                    <tr>
                        <td>{{ $value->date }}</td>
                        <td>{{ $value->description }}</td>
                        <td>{{ $value->speaker }}</td>
                        <td>{{ $value->venue }}</td>

                        <!-- we will also add show, edit, and delete buttons -->
                        <td class="table-actions">

                            <!-- show the employee (uses the show method found at GET /employees/{id} -->
                            <a class="btn show-btn" title="Show user" href="{{ URL::to('users/' . $value->id) }}">
                                <i class="fa fa-user fa-lg"></i>
                            </a>

                            <!-- edit this employee (uses the edit method found at GET /employees/{id}/edit -->
                            <a class="btn edit-btn" title="Edit user" href="{{ URL::to('users/' . $value->id . '/edit') }}">
                                 <i class="fa fa-pencil fa-lg"></i>
                            </a>

                            <!-- delete the employee (uses the destroy method DESTROY /employees/{id} -->
                            <!-- we will add this later since its a little more complicated than the other two buttons -->
                                {{ Form::open(array('url' => 'users/' . $value->id, 'class' => 'pull-right')) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                <div data-toggle="tooltip" data-placement="bottom" title="Delete" data-animation="true">
                                    {{ Form::button('<i class="fa fa-trash-o fa-lg"></i>', array('type' => 'submit', 'class' => 'btn delete-btn')) }}
                                </div>

                             {{ Form::close() }}
                            

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>  
        <a href="trainings/create">Add New Training</a>
        </section>
    </main>

@endsection
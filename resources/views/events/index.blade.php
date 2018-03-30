@extends('templates.dashboard-master')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var a = document.getElementById('events');
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

@section('body')

    <main class="container">
        <section class="container-fluid">
            <div class="row crud-page-top">
                <h1 class="crud-page-title">Events</h1>
                <button class="btn crud-main-cta" type="button" data-toggle="modal" data-target="#createModal">&#43; Add Event</button>
            </div>

            <!-- if there are creation errors, they will show here -->
            @if (Session::has('errors'))
                <div class="alert alert-warning" role="alert">
                    <strong>Warning</strong>
                    {{ Html::ul($errors->all()) }}
                </div>
            @endif

            <!-- will be used to show any messages -->
            @if (Session::has('message'))
                <div class="alert alert-info" role="alert">
                    <strong>Heads up</strong>
                    {{ Session::get('message') }}
                </div>
            @endif

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Title</td>
                        <td>Date</td>
                        <td>Starting Time</td>  
                        <td>Ending Time</td>            
                        <td>Venue</td>
                        <td class="no-stretch">Actions</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($events as $key => $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->title }}</td>
                        <td>{{ date('F d, Y', strtotime($value->date)) }}</td>
                        <td>{{ date('h:i a', strtotime($value->starting_time)) }}</td>
                        <td>{{ date('h:i a', strtotime($value->ending_time)) }}</td>   
                        <td>{{ $value->venue }}</td>

                        <td class="table-actions no-stretch">

                            <!-- show the employee (uses the show method found at GET /employees/{id} -->
                            <?php /*
                            <a class="btn show-btn" data-toggle="tooltip" data-placement="bottom" title="View event" href="{{ URL::to('events/' . $value->id) }}">
                                <i class="fa fa-user fa-lg"></i>
                            </a>
                            */ ?>

                            <!-- edit this employee (uses the edit method found at GET /employees/{id}/edit -->
                            <a class="btn edit-btn" data-toggle="tooltip" data-placement="bottom" title="Edit event" href="{{ URL::to('events/' . $value->id . '/edit') }}">
                                <i class="fa fa-pencil fa-lg"></i>
                            </a>

                                {{ Form::open(array('url' => 'events/' . $value->id, 'class' => 'pull-right')) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                <div data-toggle="tooltip" data-placement="bottom" title="Remove event">
                                    {{ Form::button('<i class="fa fa-trash-o fa-lg"></i>', array('type' => 'submit', 'class' => 'btn delete-btn')) }}
                                </div>
                             {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                {{ Form::open(array('url' => 'events')) }}
                
                <div class="form-group">
                    {{ Form::label('title', 'Title') }}
                    {{ Form::text('title', Request::old('title'), array('class' => 'form-control', 'autofocus', 'required')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('date', 'Date') }}
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
                    {{ Form::label('venue', 'Venue') }}
                    {{ Form::text('venue', Request::old('venue'), array('class' => 'form-control', 'required')) }}
                </div>
              </div>
              <div class="modal-footer create-bottom-wrapper">
                <a href="{{ URL::to('trainings') }}" class="btn cancel-btn" data-dismiss="modal">Cancel</a>
                {{ Form::submit('Create event', array('class' => 'btn btn-primary create-btn text-center')) }}
              </div>
              {{ Form::close() }}
            </div>
          </div>
        </div>
        
    </main>

@endsection

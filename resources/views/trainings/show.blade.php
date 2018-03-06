@extends('templates.dashboard-master')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

@section('body')

<h1>Training Session about {{ $training->title }} </h1>

    <div class="jumbotron text-center">
        <p>
            <strong>Date:</strong> {{ $training->date }}<br>
            <strong>Starting Time:</strong> {{ $training->starting_time }}<br>
            <strong>Ending Time:</strong> {{ $training->ending_time }}<br>
            <strong>Speaker:</strong> {{ $training->speaker }}<br>
            <strong>Venue:</strong> {{ $training->venue }}<br>
            
        </p>
    </div>

    <!-- Sorting -->
    <?php
    	$invited = array();
    	$going = array();
    ?>	
    
    @foreach($user_trainings as $key => $user_training)
    	@foreach($users as $key => $user)
    		@if($user_training->user_id == $user->id)
    			<?php
    				$temp = $user;
    			?>
    		@endif
    	@endforeach
		@if($user_training->confirmed == false)
			<?php
				array_push($invited, $temp)
			?>
		@else
			<?php
				array_push($going, $temp)
			?>
		@endif
    @endforeach
    		
   	<h5> Invited </h5>
   	<ul>
   		@foreach($invited as $key => $user)
   		<li>{{$user->first_name}} {{$user->last_name}}</li>
   		@endforeach
   	</ul>
   	<h5> Going </h5>
   	<ul>
   		@foreach($going as $key => $user)
   		<li>{{$user->first_name}} {{$user->last_name}}</li>
   		@endforeach
   	</ul>
    	
    	

    

@endsection
@extends('templates.dashboard-master')  


@section('body')

	<main class="container-fluid">
		<section class="container-fluid">

        <?php 
            $current_user = Auth::user();
            $current_id = Auth::user()->id;
            
        ?>

        @include('templates.dashboard-profile_photo', ['current_user' => $current_user, 'current_id' => $current_id])

        <section class="container dashboard-container">
            @include('templates.dashboard-skills')

            @include('templates.dashboard-trainings')

        </section>
			
       
        
        <?php 
        $evals_to_take = array(); // user trainings where quiz has already been training
        ?>
       
		</section>
	</main>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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


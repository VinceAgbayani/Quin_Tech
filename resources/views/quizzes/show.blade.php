@extends('templates.newsletter-master')

@section('body')
<h1>Showing {{ $quiz->topic }}</h1>

    <div class="jumbotron text-center">
        <h2>{{ $quiz->topic }} </h2>
        <p>
            <strong>Quiz ID Number:</strong> {{ $quiz->quiz_id }}<br>
        </p>
    </div>

   <a href="{{  URL::to('quizzes/'.$quiz->quiz_id.'/questions') }}">See Questions</a>

</table>
<!--
<a href="{{ URL::to('quizzes/'.$quiz->quiz_id.'/questions/create') }}">Add a Question</a>
-->
</div>

@endsection
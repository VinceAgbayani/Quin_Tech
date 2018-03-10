<?php
 
namespace App\Http\Controllers;

use App\Quiz;
use App\Question;
use App\User;
use App\User_Quiz;
use App\Attempt;
Use App\Skill;
use App\Section;
use App\Training;
use App\Section_Attempt;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use View;

class QuizController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function verify_pw(Request $request)
    {
        $user_id = Input::get('user_id');

        $quiz = Quiz::find(Input::get('quiz_id'));
        $realpw = Input::get('password');
        $idealpw = $quiz->password;
        //if mali password
        if($realpw != $idealpw)
        {
            Session::flash('message', 'MALI PASSWORD MO BRAD. Nilagay mo:'.$realpw.', Ang dapat: '.$idealpw);
            return Redirect::to('levels');
        }
        else
        {
            return Redirect::to('quizzes/' . $quiz->quiz_id . '/take')
            ->with('user_id', $user_id);
        }      

    }
    
    public function take($quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        $user_id = Input::get('user_id');

        $sections = Section::where('quiz_id',$quiz_id)->get();
        $questions = array();

        foreach ($sections as $key => $section) {
            $questions_temps = $section->questions()->get();
            foreach ($questions_temps as $key => $questions_temp) {
                array_push($questions,$questions_temp);
            }
        }

        return View::make('quizzes.take')
            ->with('quiz', $quiz)
            ->with('questions', $questions);
    }

    public function record(Request $request)
    {
        // Generic

            $quiz_id = Input::get('quiz_id'); 

        // User Quiz Instantiation
        
            $user_quiz = new User_Quiz; // New Instance of User Quiz
            $user_quiz->user_id = Auth::user()->id; //User Quiz Details
            $user_quiz->quiz_id = $quiz_id; //User Quiz Details
            $user_quiz->save(); // Save so that its ID can be retreived

            $init_quiz_score = 0; 

        // Put User Quiz ID

            $user_quiz_id = $user_quiz->id; // Get ID User_Quiz ID for Section

        // Get Questions for Checking of Attempts

            $quiz = Quiz::find($quiz_id);
            $sections = Section::where('quiz_id',$quiz_id)->get();
            $questions = array();
    
            foreach ($sections as $key => $section) {
                $questions_temps = $section->questions()->get();
                foreach ($questions_temps as $key => $questions_temp) {
                    array_push($questions,$questions_temp);
                }

                $section_attempt = new Section_Attempt;
                $section_attempt->user_quiz_id =  $user_quiz_id;
                $section_attempt->section_id = $section->id;
                $section_attempt->score = 0;
                $section_attempt->max_score = 0;
                $section_attempt->save();
            }

        // Get Attempts of User

            $answer_attempt = Input::get("answer_attempt");

            $quiz_max_score = count($questions);

            for ($i = 0; $i < count($questions); $i++)
            {   
            
                // Attempt Instantiation
                $attempt = new Attempt;
                $attempt->question_id = $questions[$i]->id;

                // Section Assignment of Attempt

                $section_attempts = Section_Attempt::where('user_quiz_id', $user_quiz_id)->get();

                foreach ($section_attempts as $key => $section_attempt) {

                    if($section_attempt->section_id == $questions[$i]->section_id)
                    {
                        $attempt->section_attempt_id = $section_attempt->id;

                        $max_score = $section_attempt->max_score;
                        $max_score++;
                        $section_attempt->max_score = $max_score;
                        $user_quiz->max_score += $max_score;
                        $section_attempt->save();
                    }   

                }

                // Answer Attempt Assignment of Attempt
                $attempt->answer_attempt = $answer_attempt[$i];

                // Get correct answer and attempt answer
                $correct_answer = $questions[$i]->answer_item;
                $attempt_answer =  $attempt->answer_attempt;

                // Problematic

                // ------------

                

                if ($correct_answer == $attempt_answer)
                {
                    foreach ($section_attempts as $key => $section_attempt) {

                    if($section_attempt->section_id == $questions[$i]->section_id)
                    {
                        $attempt->section_attempt_id = $section_attempt->id;

                        $init_score = $section_attempt->score;
                        $init_score++;
                        $section_attempt->score = $init_score;
                        $section_attempt->save();
                    }   

                }
                }

                // ------------

                $attempt->save();
            }

        // Gather scores of sections
            foreach ($section_attempts as $key => $section_attempt) {
                $section_score = $section_attempt->score;
                $init_quiz_score+=$section_score;
            }

            // WORKING GREAT
            $user_quiz->score = $init_quiz_score;

            $user_quiz->save();

        // redirect
            Session::flash('message', 'Successfully taken quiz! Congratulations!'
         );
        
        return Redirect::to('levels');

    }

    public function results()
    {
         // get all the assessments
        $user_quiz = User_Quiz::all();
        $users = User::all();
        $quizzes = Quiz::all();

        // load the view and pass the stuff
        return View::make('quizzes.results')
            ->with('user_quiz', $user_quiz)
            ->with('users', $users)
            ->with('quizzes', $quizzes);
    }

    public function take_quizzes()
    {
         // get all the quizzes
        $quizzes = Quiz::all();
        $user_quizzes = User_Quiz::all(); // FIX THIS SOON

        // load the view and pass the quizzes
        return View::make('quizzes.take_quizzes')
            ->with('quizzes', $quizzes)
            ->with('user_quizzes', $user_quizzes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
         // get all the quizzes
        $quizzes = Quiz::all();
        $user_quizzes = User_Quiz::all();
        $trainings = Training::all();



        // load the view and pass the quizzes
        return View::make('quizzes.index')
            ->with('quizzes', $quizzes)
            ->with('user_quizzes', $user_quizzes)
            ->with('trainings', $trainings);      

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // load the create form (app/views/quizzes/create.blade.php)
        $trainings = Training::all();

        return View::make('quizzes.create')
            ->with('trainings', $trainings);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'topic'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('quizzes/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $quiz = new Quiz;
            $quiz->topic = Input::get('topic');
            $quiz->password = Input::get('password');
            $quiz->training_id = Input::get('training_id');
            $quiz->save();

            // redirect
            Session::flash('message', 'Successfully created quiz!');
            return Redirect::to('quizzes');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show($quiz_id)
    {
        // get the quiz
        $quiz = Quiz::find($quiz_id);
        $skill = Skill::find($quiz->skill_id);

        //$questions = Question::find($quiz_id)->questions();

       //$questions = Question::find(1)->questions()->where('quiz_id', '$quiz_id')->first();

        // show the view and pass the quiz to it
        return View::make('quizzes.show')
            ->with('quiz', $quiz)
            ->with('skill', $skill);
        //->with('questions', $questions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit($quiz_id)
    {
        //get skills
        $trainings = Training::all();
         // get the quiz
        $quiz = Quiz::find($quiz_id);

        // show the edit form and pass the quiz
        return View::make('quizzes.edit')
            ->with('quiz', $quiz)
            ->with('trainings', $trainings);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update($quiz_id)
    {
         // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'topic'       => 'required',            
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('quizzes/' . $quiz_id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
             // store
            $quiz = Quiz::find($quiz_id);
            $quiz->topic = Input::get('topic');
            $quiz->training_id = Input::get('training_id');
            $quiz->save();

            // redirect
            Session::flash('message', 'Successfully updated quiz!');
            return Redirect::to('quizzes');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy($quiz_id)
    {
        // delete
        $quiz = Quiz::find($quiz_id);
        $quiz->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the quiz!');
        return Redirect::to('quizzes');
    }
}

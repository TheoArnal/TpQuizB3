<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Score;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Quiz::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $questions = $request["questions"];
        $data = json_decode($request->getContent());
        $quiz = new Quiz();
        $quiz->label = $data->label;
        $quiz->save();
        foreach ($questions as $question) {
            $Question = new Question();
            $Question["quiz_id"] = $quiz->id;
            $Question["label"] = $question["label"];
            $Question["answer"] = null;
            $Question["earnigs"] = $question["earnings"];
            $Question->save();
            foreach ($question["choices"] as $choise){
                $Choise = new Choice();
                $Choise["question_id"] = $question["id"];
                $Choise["label"] = $choise["label"];
                $Choise->save();
                if ($choise['id'] == $question["answer"]) {
                    $Question["answer"] = $Choise["id"];
                    $Question->save();
                }
            }
            $Question->save();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(int $quiz)
    {
        $user = Quiz::find($quiz);
        return response()->json($user);
    }

    public function questions(int $id){
        $quiz = Quiz::find($id);
        //$question = Question::find($id);
        return response()->json($quiz->questions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, int $id)
    {
        $quiz = Quiz::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $quiz = Quiz::find($id);
        $questions = Question::where("quiz_id", $id)->get();
        foreach ($questions as $question){
            Choice::where("question_id", $question["id"])->delete();
        }
        Question::where("quiz_id", $id)->delete();
        Score::where("quiz_id", $id)->delete();
        $quiz->delete();

        return $this->store($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        Quiz::find($id)->delete();
    }

    public function unpublish(int $id) {
        $quiz = Quiz::find($id);
        $quiz->published = false;
        $quiz->save();
    }

    public function publish(int $id) {
        $quiz = Quiz::find($id);
        $quiz->published = true;
        $quiz->save();
    }


}

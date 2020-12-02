<?php

namespace App\Http\Controllers;

use App\SurveyQuestion;
use App\Institution;
use App\SurveyResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Solutions;
use App\SolutionsAnswers;

class UserController extends Controller
{
    public function index(){
        $survey_question = SurveyQuestion::inRandomOrder()->get();
        $user = Auth::user();        

        $survey_question = $survey_question->toArray();
        $options = [1, 2, 3, 4, 5];
        shuffle($options);

        // var_dump($options);

        return view('user.survey', ['survey_question' => $survey_question, 'user' => $user, 'options' => $options]);
    }

    public function submit(Request $request){
        $user = Auth::user();
        $data_institution = Institution::where('id', $user->institution_id)->get()->first();
        $allinput = $request->all();

        if($data_institution !== null){
            if($data_institution->response >= $data_institution->max_response){
                $message = 'Max response sudah terpenuhi, tidak menerima response kembali';
                return redirect('/user/dashboard')->with(['error' => $message]);
            }
            else{
                $check_survey = SurveyResponse::where('user_id', $user->id)->get()->first();
                if(isset($check_survey) && $check_survey !== null){
                    SurveyResponse::where('user_id', $user->id)->delete();
                }
                
                $last_no_question = SurveyQuestion::latest('no_question')->first();
                for($i = 1; $i <= $last_no_question->no_question; $i++){
                    SurveyResponse::create([
                        'user_id' => $user->id,
                        'question_id' => $allinput['questionid'.$i],
                        'institution_id' => $data_institution->id,
                        'answer' => $allinput['question'.$i]
                    ]);                    
                }
                $message = 'Berhasil mengisi survey';
                Institution::where('id', $data_institution->id)->update(['response' => ($data_institution->response+1)]);
                return redirect('/user/dashboard')->with(['success' => $message]);
            }
        }
        else{
            $message = 'Institusi tidak terdaftar';
            return redirect('/survey')->with(['error' => $message]);
        }

    }

    public function dashboard(){
        $user = Auth::user();
        $check_surveyresponse = SurveyResponse::where('user_id', $user->id)->get()->first();

        return view('user.dashboard', ['checkresponse' => $check_surveyresponse]);
    }

    public function hasilPersonal(){
        $user = Auth::user();
        $hasil_survey = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? GROUP BY sq.dimensi ORDER BY sq.dimensi = ? DESC, rata DESC', [$user->id, 'risk']);
        return view('user.hasilpersonal', ['hasil_survey' => $hasil_survey, 'user' => $user]);
    }

    public function getHasilPersonal(){
        $user = Auth::user();
        $hasil_survey = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? AND sq.dimensi <> ? GROUP BY sq.dimensi ORDER BY rata DESC', [$user->id, 'risk']);
        return response()->json(['hasil_survey' => $hasil_survey] , Response::HTTP_OK);  
    }

    public function hasilInstitusi(){                
        $user = Auth::user();
        $data_institution = Institution::where('id', $user->institution_id)->get()->first();
        
        $hasil_survey_institusi = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? GROUP BY sq.dimensi ORDER BY sq.dimensi = ? DESC, rata DESC', [$data_institution->id, 'risk']);
        return view('user.hasilinstitusi', ["hasil_survey_institusi" => $hasil_survey_institusi, "data_institution" => $data_institution]);        
    }

    public function getHasilInstitusi(){                
        $user = Auth::user();
        $data_institution = Institution::where('id', $user->institution_id)->get()->first();
        
        $hasil_survey_institusi = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? AND sq.dimensi <> ? GROUP BY sq.dimensi ORDER BY rata DESC', [$data_institution->id, 'risk']);
        return response()->json(['hasil_survey_institusi' => $hasil_survey_institusi] , Response::HTTP_OK);  
    }

    public function solusi(){
        $user = Auth::user();
        $solanswer_assoc = [];
        $solution_answer = SolutionsAnswers::where('user_id', $user->id)->get();
        $lowest_dimensi = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? GROUP BY sq.dimensi ORDER BY rata ASC LIMIT 3', [$user->institution_id]);        
        $first_lowest = Solutions::where('dimensi', $lowest_dimensi[0]->dimensi)->get();
        $second_lowest = Solutions::where('dimensi', $lowest_dimensi[1]->dimensi)->get();
        $third_lowest = Solutions::where('dimensi', $lowest_dimensi[2]->dimensi)->get();        

        foreach($solution_answer as $solution){
            $solanswer_assoc['solanswer'.$solution->solution_id] = $solution->is_done;
        }
        
        // echo $solanswer_assoc['solanswer2'];

        // foreach($first_lowest as $first){
        //     echo $first->id;
        // }
        // echo $first_lowest[0]->dimensi;
        return view('user.solusi', ["first_lowest" => $first_lowest, "second_lowest" => $second_lowest, "third_lowest" => $third_lowest, 'solanswer_assoc' => $solanswer_assoc]);
    }

    public function solusiSave(Request $request){
        $user = Auth::user();
        $allinput = $request->all();
        foreach($allinput['solution_id'] as $solution){
            echo $solution;
            $solution_answer = SolutionsAnswers::where('user_id', $user->id)->where('solution_id', $solution)->get()->first();
            
            if($solution_answer === null){
                SolutionsAnswers::create([
                    'user_id' => $user->id,
                    'solution_id' => $solution,
                    'is_done' => $allinput['solutions'.$solution]
                ]);
            }
            else{
                SolutionsAnswers::where('user_id', $user->id)->where('solution_id', $solution)
                                ->update([
                                    'is_done' => $allinput['solutions'.$solution]
                                ]);
            }
            
        }
        return redirect('/survey/solusi');        
    }

    private function storeQuestion($user_id, $question_id, $institution_id, $answer){
        SurveyResponse::create([
            'user_id' => $user_id,
            'question_id' => $question_id,
            'institution_id' => $institution_id,
            'answer' => $answer
        ]);
    }    
}


<?php

namespace App\Http\Controllers;

use App\SurveyQuestion;
use App\Institution;
use App\Pembobotan;
use App\SurveyResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Solutions;
use App\SolutionsAnswers;
use App\SurveyQuestionGroup;
use App\Score;
use App\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(){
        // $survey_question = SurveyQuestion::inRandomOrder()->get();        
        $user = Auth::user();        
        $survey_question = SurveyQuestionGroup::where('institution_id', $user->institution_id)
                            ->inRandomOrder()
                            ->get();        

        if($survey_question->isEmpty()){
            $message = 'Soal survey untuk anda belum siap';
            return redirect('/user/dashboard')->with(['error' => $message]);
        }

        $survey_question = $survey_question->toArray();
        $options = [1, 2, 3, 4, 5];
        shuffle($options);

        // var_dump($options);
        
        return view('user.survey', ['survey_question' => $survey_question, 'user' => $user, 'options' => $options]);
    }

    public function submit(Request $request){
        try{
            $user = Auth::user();
            $data_institution = Institution::where('id', $user->institution_id)->get()->first();
            $allinput = $request->all();

            if(empty($data_institution)){
                $message = 'Institusi tidak terdaftar';
                return redirect('/survey')->with(['error' => $message]);
            }
            // if($data_institution->response >= $data_institution->max_response){
            //     $message = 'Max response sudah terpenuhi, tidak menerima response kembali';
            //     return redirect('/user/dashboard')->with(['error' => $message]);
            // }            

            $check_survey = SurveyResponse::where('user_id', $user->id)->get()->first();
            if(!empty($check_survey)){
                SurveyResponse::where('user_id', $user->id)->delete();
            }
            
            $last_no_question = SurveyQuestionGroup::where('institution_id', $user->institution_id)
                                ->latest('no_question')
                                ->first();

            for($i = 1; $i <= $last_no_question->no_question; $i++){
                SurveyResponse::create([
                    'user_id' => $user->id,
                    'question_id' => $allinput['questionid'.$i],
                    'institution_id' => $data_institution->id,
                    'answer' => $allinput['question'.$i]
                ]);                    
            }

            $hasil_survey = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_group_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? GROUP BY sq.dimensi ORDER BY sq.dimensi DESC', [$user->id]);                
            
            $checkUserExpert = User::join('institution', 'institution.id', 'users.institution_id')
                                ->where('institution.id', $user->institution_id)
                                ->select(
                                    'institution.category'
                                )
                                ->first();
            
            $institutionExpert = [];
            
            if($checkUserExpert->category == "expert"){
                $institutionExpert = Institution::where('category', 'expert')
                                            ->where('id', $user->institution_id)
                                            ->first();    
            }
            elseif($checkUserExpert->category != "expert" && $checkUserExpert->category != "umum"){
                $institutionExpert = Institution::where('category', 'expert')
                                    ->where('parent_id', $user->institution_id)
                                    ->first();
            }            

            // $check_score = Score::where('user_id', $user->id)
            //                 ->get();        

            if($checkUserExpert->category == "expert" || $checkUserExpert->category == "umum"){
                if($checkUserExpert->category == "umum"){                                
                    foreach ($hasil_survey as $item) {
                        $check_score = Score::where('user_id', $user->id)
                                        ->where('dimensi', $item->dimensi)
                                        ->where('institution_id', $user->institution_id)
                                        ->first();
                        if(empty($check_score)){
                            Score::create([
                                'dimensi' => $item->dimensi,
                                'score_angka' => $item->rata,
                                'user_id' => $user->id,
                                'institution_id' => $user->institution_id
                            ]);
                        }
                        else{
                            Score::where('user_id', $user->id)
                                ->where('institution_id', $user->institution_id)
                                ->where('dimensi', $item->dimensi)
                                ->update([
                                'dimensi' => $item->dimensi,
                                'score_angka' => $item->rata,
                                'user_id' => $user->id,
                                'institution_id' => $user->institution_id
                            ]); 
                        }
                    }
                }
                // START JIKA USER ADALAH EXPERT
                elseif($checkUserExpert->category == "expert"){
                    $hasil_survey = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi AS dimensi FROM survey_response sr, survey_group_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? GROUP BY sq.dimensi ORDER BY sq.dimensi DESC', [$institutionExpert->id]);
                    $userSameInstitutionExpert = SurveyResponse::where('institution_id', $institutionExpert->parent_id)                    
                                                ->select('user_id', 'institution_id')
                                                ->groupBy('institution_id')
                                                ->groupBy('user_id')
                                                ->get();
                    // $arrayUsersSameInstitution = array();
                    // UPDATE NILAI TIAP USER
                    foreach($userSameInstitutionExpert as $item){
                        $hasil_survey_UserSameInstitution = DB::select('SELECT avg(sr.answer) AS ratauser, sq.dimensi AS dimensiuser FROM survey_response sr, survey_group_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? GROUP BY sq.dimensi ORDER BY sq.dimensi DESC', [$item->user_id]);
                        $pembobotan = Pembobotan::where('institution_id', $institutionExpert->parent_id)
                                ->first();
                        $persenExpert = (float)$pembobotan->nilai_expert;
                        $persenUsers = (float)$pembobotan->nilai_users;
                        // $mergeExpertUserSameInstitution = array_merge($hasil_survey, $hasil_survey_UserSameInstitution);
                        $mergeExpertUserSameInstitution = array();

                        for($i = 0; $i < count($hasil_survey_UserSameInstitution); $i++){
                            $eachDimensiUserExpert = [
                                "dimensiuser" => $hasil_survey_UserSameInstitution[$i]->dimensiuser,
                                "ratauser" => $hasil_survey_UserSameInstitution[$i]->ratauser,
                                "rata" => $hasil_survey[$i]->rata
                            ];
                            array_push($mergeExpertUserSameInstitution, $eachDimensiUserExpert);
                        }                        
                        // var_dump($mergeExpertUserSameInstitution);
                        foreach($mergeExpertUserSameInstitution as $item2){
                            $check_score = Score::where('user_id', $item->user_id)
                                        ->where('dimensi', $item2["dimensiuser"])
                                        ->where('institution_id', $item->institution_id)
                                        ->first();
                            if(empty($check_score)){
                                Score::create([
                                    'dimensi' => $item2["dimensiuser"],
                                    'score_angka' => (($item2["ratauser"] * $persenUsers / 100) + ($item2["rata"] * $persenExpert / 100)) / 2,
                                    'user_id' => $item->user_id,
                                    'institution_id' => $item->institution_id
                                ]);
                            }
                            else{
                                Score::where('user_id', $item->user_id)
                                    ->where('institution_id', $item->institution_id)
                                    ->where('dimensi', $item2["dimensiuser"])
                                    ->update([
                                    'dimensi' => $item2["dimensiuser"],
                                    'score_angka' => (($item2["ratauser"] * $persenUsers) + ($item2["rata"] * $persenExpert)) / 2,
                                    'user_id' => $item->user_id,
                                    'institution_id' => $item->institution_id
                                ]); 
                            }
                        }
                        // array_push($arrayUsersSameInstitution, $mergeExpertUserSameInstitution);
                    }                            
                    // SIMPAN NILAI SENDIRI
                    foreach ($hasil_survey as $item) {
                        $check_score = Score::where('user_id', $user->id)
                                        ->where('dimensi', $item->dimensi)
                                        ->where('institution_id', $user->institution_id)
                                        ->first();
                        if(empty($check_score)){
                            Score::create([
                                'dimensi' => $item->dimensi,
                                'score_angka' => $item->rata,
                                'user_id' => $user->id,
                                'institution_id' => $user->institution_id
                            ]);
                        }
                        else{
                            Score::where('user_id', $user->id)
                                ->where('institution_id', $user->institution_id)
                                ->where('dimensi', $item->dimensi)
                                ->update([
                                'dimensi' => $item->dimensi,
                                'score_angka' => $item->rata,
                                'user_id' => $user->id,
                                'institution_id' => $user->institution_id
                            ]); 
                        }
                    }
                    
                }
                // END JIKA USER ADALAH EXPERT
            }
            // JIKA USER ADALAH USERPERUSAHAAN
            else{
                $hasil_survey_expert = DB::select('SELECT avg(sr.answer) AS rataexpert, sq.dimensi AS dimensiexpert FROM survey_response sr, survey_group_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? GROUP BY sq.dimensi ORDER BY sq.dimensi DESC', [$institutionExpert->id]);
                if(empty($hasil_survey_expert)){
                    foreach ($hasil_survey as $item) {
                        $check_score = Score::where('user_id', $user->id)
                                        ->where('dimensi', $item->dimensi)
                                        ->where('institution_id', $user->institution_id)
                                        ->first();
                        if(empty($check_score)){
                            Score::create([
                                'dimensi' => $item->dimensi,
                                'score_angka' => $item->rata,
                                'user_id' => $user->id,
                                'institution_id' => $user->institution_id
                            ]);
                        }
                        else{
                            Score::where('user_id', $user->id)
                                ->where('institution_id', $user->institution_id)
                                ->where('dimensi', $item->dimensi)
                                ->update([
                                'dimensi' => $item->dimensi,
                                'score_angka' => $item->rata,
                                'user_id' => $user->id,
                                'institution_id' => $user->institution_id
                            ]); 
                        }
                    }
                }
                else{
                    $pembobotan = Pembobotan::where('institution_id', $user->institution_id)
                                ->first();
                    $persenExpert = (float)$pembobotan->nilai_expert;
                    $persenUsers = (float)$pembobotan->nilai_users;
                    $mergeExpertUser = array();

                    for($i = 0; $i < count($hasil_survey); $i++){
                        $eachDimensiUserExpert = [
                            "dimensi" => $hasil_survey[$i]->dimensi,
                            "rata" => $hasil_survey[$i]->rata,
                            "rataexpert" => $hasil_survey_expert[$i]->rataexpert
                        ];
                        array_push($mergeExpertUser, $eachDimensiUserExpert);
                    }               
                    foreach ($mergeExpertUser as $item) {
                        $check_score = Score::where('user_id', $user->id)
                                        ->where('dimensi', $item["dimensi"])
                                        ->where('institution_id', $user->institution_id)
                                        ->first();
                        if(empty($check_score)){
                            Score::create([
                                'dimensi' => $item["dimensi"],
                                'score_angka' => (($item["rata"] * $persenUsers / 100) + ($item["rataexpert"] * $persenExpert / 100)) / 2,
                                'user_id' => $user->id,
                                'institution_id' => $user->institution_id
                            ]);
                        }
                        else{
                            Score::where('user_id', $user->id)
                                ->where('institution_id', $user->institution_id)
                                ->where('dimensi', $item["dimensi"])
                                ->update([
                                'dimensi' => $item["dimensi"],
                                'score_angka' => (($item["rata"] * $persenUsers / 100) + ($item["rataexpert"] * $persenExpert / 100)) / 2,
                                'user_id' => $user->id,
                                'institution_id' => $user->institution_id
                            ]); 
                        }
                    }
                }   
            }                     
            $message = 'Berhasil mengisi survey';
            Institution::where('id', $data_institution->id)->update(['response' => ($data_institution->response+1)]);
            return redirect('/user/dashboard')->with(['success' => $message]);   
        }    
        catch (\Exception $e) {
            return redirect('/user/dashboard')->with(["error" => $e->getMessage()]);
        }            
    }

    public function dashboard(){
        $user = Auth::user();
        $check_surveyresponse = SurveyResponse::where('user_id', $user->id)->get()->first();

        return view('user.dashboard', ['checkresponse' => $check_surveyresponse]);
    }

    public function hasilPersonal(){
        $user = Auth::user();
        // $hasil_survey = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_group_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? GROUP BY sq.dimensi ORDER BY sq.dimensi = ? DESC, rata DESC', [$user->id, 'risk']);                
        $hasil_survey = Score::where('user_id', $user->id)
                        ->select('score_angka AS rata', 'dimensi')                                                                        
                        ->orderByRaw("FIELD(dimensi , 'risk') DESC")
                        ->orderBy('score_angka', 'DESC')
                        ->get();
        $altSolusi = Solutions::join('solutions_answers', 'solutions_answers.solution_id', 'solutions.id')
                    ->where('solutions_answers.user_id', $user->id)
                    ->select(
                        ['solutions.dimensi',
                        'solutions.solution',
                        'solutions.article',
                        'solutions.tahun',
                        'solutions.author',
                        'solutions.link_doi',
                        'solutions.company_background',
                        'solutions.keterangan']
                    )
                    ->get();
        return view('user.hasilpersonal', ['hasil_survey' => $hasil_survey, 'user' => $user, 'altSolusi' => $altSolusi]);
    }

    public function hasilPersonalFull(){
        $user = Auth::user();
        // $hasil_survey = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_group_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? GROUP BY sq.dimensi ORDER BY sq.dimensi = ? DESC, rata DESC', [$user->id, 'risk']);                
        $hasil_survey = Score::where('user_id', $user->id)
                        ->select('score_angka AS rata', 'dimensi')                                                                        
                        ->orderByRaw("FIELD(dimensi , 'risk') DESC")
                        ->orderBy('score_angka', 'DESC')
                        ->get();
        $altSolusi = Solutions::join('solutions_answers', 'solutions_answers.solution_id', 'solutions.id')
                    ->where('solutions_answers.user_id', $user->id)
                    ->select(
                        ['solutions.dimensi',
                        'solutions.solution',
                        'solutions.article',
                        'solutions.tahun',
                        'solutions.author',
                        'solutions.link_doi',
                        'solutions.company_background',
                        'solutions.keterangan']
                    )
                    ->get();
        return view('user.hasilpersonalfull', ['hasil_survey' => $hasil_survey, 'user' => $user, 'altSolusi' => $altSolusi]);
    }

    public function getHasilPersonal(){
        $user = Auth::user();
        $hasil_survey = Score::where('user_id', $user->id)
                        ->where('dimensi', '<>', 'risk')
                        ->select('score_angka AS rata', 'dimensi')                                                                        
                        ->orderBy('score_angka', 'DESC')
                        ->get();
        // $hasil_survey = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_group_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? AND sq.dimensi <> ? GROUP BY sq.dimensi ORDER BY rata DESC', [$user->id, 'risk']);
        return response()->json(['hasil_survey' => $hasil_survey] , Response::HTTP_OK);  
    }

    public function hasilInstitusi(){                
        $user = Auth::user();
        $data_institution = Institution::where('id', $user->institution_id)->get()->first();
        $hasil_survey_institusi = Score::where('institution_id', $user->institution_id)
                        ->select(DB::raw('avg(score_angka) as rata'), 'dimensi')                                                                        
                        ->groupBy('dimensi')
                        ->orderByRaw("FIELD(dimensi , 'risk') DESC")
                        ->orderBy('score_angka', 'DESC')
                        ->get();
        // $hasil_survey_institusi = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_group_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? GROUP BY sq.dimensi ORDER BY sq.dimensi = ? DESC, rata DESC', [$data_institution->id, 'risk']);
        return view('user.hasilinstitusi', ["hasil_survey_institusi" => $hasil_survey_institusi, "data_institution" => $data_institution]);        
    }

    public function getHasilInstitusi(){                
        $user = Auth::user();
        $data_institution = Institution::where('id', $user->institution_id)->get()->first();
        $hasil_survey_institusi = Score::where('institution_id', $user->institution_id)
                        ->select(DB::raw('avg(score_angka) as rata'), 'dimensi')                                                                        
                        ->where('dimensi', '<>', 'risk')
                        ->groupBy('dimensi')
                        ->orderByRaw("FIELD(dimensi , 'risk') DESC")
                        ->orderBy('score_angka', 'DESC')
                        ->get();
        // $hasil_survey_institusi = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_group_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? AND sq.dimensi <> ? GROUP BY sq.dimensi ORDER BY rata DESC', [$data_institution->id, 'risk']);
        return response()->json(['hasil_survey_institusi' => $hasil_survey_institusi] , Response::HTTP_OK);  
    }

    public function solusi(){
        $user = Auth::user();
        // $solanswer_assoc = [];
        $scoreUser = Score::where("user_id", $user->id)
                    ->orderBy("score_angka", "ASC")
                    ->get()
                    ->toArray();            
        $first_lowest = Solutions::where("dimensi", $scoreUser[0]["dimensi"])
                                    ->get();
        
        $second_lowest = Solutions::where("dimensi", $scoreUser[1]["dimensi"])
                            ->get();  

        $solutionAnswerById = SolutionsAnswers::where('user_id', $user->id)                            
                            ->get();    
                                
        $solutionIdOnAnswer = array();

        foreach ($solutionAnswerById as $item) {
            array_push($solutionIdOnAnswer, $item->solution_id);
        }

        foreach($first_lowest as $item){
            $item->status_import = "no";
            if(in_array($item->id, $solutionIdOnAnswer)){
                $item->status_import = "yes";
            }
        }        

        foreach($second_lowest as $item){
            $item->status_import = "no";
            if(in_array($item->id, $solutionIdOnAnswer)){
                $item->status_import = "yes";
            }
        }
        
        // $solutionUser = Solutions::where("user_id", $user->id)
        //                 ->orderBy("")
        // $solution_answer = SolutionsAnswers::where('user_id', $user->id)->get();
        // $lowest_dimensi = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? GROUP BY sq.dimensi ORDER BY rata ASC LIMIT 3', [$user->institution_id]);        
        // $first_lowest = Solutions::where('dimensi', $lowest_dimensi[0]->dimensi)->get();
        // $second_lowest = Solutions::where('dimensi', $lowest_dimensi[1]->dimensi)->get();
        // $third_lowest = Solutions::where('dimensi', $lowest_dimensi[2]->dimensi)->get();        

        // foreach($solution_answer as $solution){
        //     $solanswer_assoc['solanswer'.$solution->solution_id] = $solution->is_done;
        // }
        
        // echo $solanswer_assoc['solanswer2'];

        // foreach($first_lowest as $first){
        //     echo $first->id;
        // }
        // echo $first_lowest[0]->dimensi;
        return view('user.solusi', ["first_lowest" => $first_lowest, "second_lowest" => $second_lowest, "scoreUser" => $scoreUser]);
    }

    public function solusiSave(Request $request){
        try{
            $user = Auth::user();
            $solution_id = $request->solution_id;
            $checkSolutionAnswer = SolutionsAnswers::where("user_id", $user->id)
                                                    ->where("solution_id", $solution_id)
                                                    ->first();

            if(empty($checkSolutionAnswer)){
                SolutionsAnswers::create([
                    "user_id" => $user->id,
                    "solution_id" => $solution_id
                ]);
            }            
            
            $success = "Berhasil menyimpan alternatif solusi";
            return response()->json(['success' => $success] , Response::HTTP_OK);        
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()] , Response::HTTP_OK);  
        }            
    } 
    
    public function solusiDelete(Request $request){
        try{
            $user = Auth::user();
            $solution_id = $request->solution_id;
            SolutionsAnswers::where("user_id", $user->id)
                            ->where("solution_id", $solution_id)
                            ->delete();                       
            
            $success = "Berhasil delete alternatif solusi";
            return response()->json(['success' => $success] , Response::HTTP_OK);        
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()] , Response::HTTP_OK);  
        }            
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


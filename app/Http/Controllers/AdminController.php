<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institution;
use App\Solutions;
use App\SurveyQuestion;
use App\User;
use Illuminate\Support\Facades\DB;
use PDO;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function indexInstitusi(){
        $institution = Institution::all();        
        return view('admin.hasilinstitusi', ['institution' => $institution]);
    }

    public function indexPersonal(){
        $users = User::all();
        return view('admin.hasilpersonal', ['users' => $users]);
    }

    public function institusiById(Request $request){
        $institution = Institution::all();        
        $institutionbyid = Institution::where('id', $request->institution_id)->get()->first();
        if($institutionbyid === null){
            return redirect('/admin/hasil/institusi');
        }
        $survey_institusi_admin = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? GROUP BY sq.dimensi ORDER BY rata DESC', [$request->institution_id]);
        
        return view('admin.hasilinstitusi', ['institution' => $institution, 'survey_institusi_admin' => $survey_institusi_admin, 'institutionbyid' => $institutionbyid]);    
        
    }

    public function getInstitusi(Request $request){                    
        $hasil_survey_institusi = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? GROUP BY sq.dimensi ORDER BY rata DESC', [$request->institution_id]);
        return response()->json(['hasil_survey_institusi' => $hasil_survey_institusi] , Response::HTTP_OK);  
    }

    public function personalById(Request $request){
        $users = User::all();        
        $userbyid = User::where('id', $request->user_id)->get()->first();
        if($userbyid === null){
            return redirect('/admin/hasil/personal');
        }
        $survey_personal_admin = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? GROUP BY sq.dimensi ORDER BY rata DESC', [$request->user_id]);
        
        return view('admin.hasilpersonal', ['users' => $users, 'survey_personal_admin' => $survey_personal_admin, 'userbyid' => $userbyid]);    
        
    }
    public function getPersonal(Request $request){                    
        $hasil_survey_personal = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? GROUP BY sq.dimensi ORDER BY rata DESC', [$request->user_id]);
        return response()->json(['hasil_survey_personal' => $hasil_survey_personal] , Response::HTTP_OK);  
    }

    public function indexSolusi(){
        $solutions = Solutions::all();

        return view('admin.solusi', ['solutions' => $solutions]);
    }

    public function createSolusi(Request $request){
        Solutions::create([
            'dimensi' => $request->dimensi,
            'solution' => $request->solution,
            'article' => $request->article,
            'tahun' => $request->tahun,
            'author' => $request->author,
            'link_doi' => $request->link_doi,
            'company_background' => $request->company_background,
            'keterangan' => $request->keterangan,
        ]);

        return redirect('/admin/solusi');

    }

    public function updateSolusi(Request $request){
        Solutions::where('id', $request->solutions_id)->update([
            'dimensi' => $request->dimensi,
            'solution' => $request->solution,
            'article' => $request->article,
            'tahun' => $request->tahun,
            'author' => $request->author,
            'link_doi' => $request->link_doi,
            'company_background' => $request->company_background,
            'keterangan' => $request->keterangan,
        ]);

        return redirect('/admin/solusi');
    }

    public function deleteSolusi(Request $request){
        Solutions::where('id', $request->solutions_id)->delete();
        return redirect('/admin/solusi');
    }

    public function indexQuestion(){
        $survey_question = SurveyQuestion::all();

        return view('admin.question', ['survey_question' => $survey_question]);
    }

    public function createQuestion(Request $request){
        // echo $request->option_1;
        SurveyQuestion::create([
            'dimensi' => $request->dimensi,
            'category' => $request->category,
            'no_question' => $request->no_question,
            'keyword' => $request->keyword,
            'text_question' => $request->text_question,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'option_5' => $request->option_5,
        ]);

        return redirect('/admin/question');
    }

    public function updateQuestion(Request $request){
        SurveyQuestion::where('id', $request->question_id)->update([
            'dimensi' => $request->dimensi,
            'category' => $request->category,
            'no_question' => $request->no_question,
            'keyword' => $request->keyword,
            'text_question' => $request->text_question,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'option_5' => $request->option_5,
        ]);
        return redirect('/admin/question');
    }

    public function deleteQuestion(Request $request){
        SurveyQuestion::where('id', $request->question_id)->delete();

        return redirect('/admin/question');
    }

    public function indexInstitution(){
        $institutions = Institution::all();

        return view('admin.institution', ['institutions' => $institutions]);
    }

    public function createInstitution(Request $request){
        Institution::create([
            'institution_name' => $request->institution_name,
            'institution_code' => $request->institution_code,
            'max_response' => $request->max_response,
        ]);
        return redirect('/admin/institution');
    }

    public function updateInstitution(Request $request){
        // echo $request;
        Institution::where('id', $request->institution_id)->update([
            'institution_name' => $request->institution_name,
            'institution_code' => $request->institution_code,
            'max_response' => $request->max_response,
        ]);
        return redirect('/admin/institution');
    }

    public function deleteInstitution(Request $request){
        Institution::where('id', $request->institution_id)->delete();
        return redirect('/admin/institution');
    }
}

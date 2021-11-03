<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institution;
use App\Solutions;
use App\SurveyQuestion;
use App\SurveyCategory;
use App\User;
use Illuminate\Support\Facades\DB;
use PDO;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function index(){
        return view('superadmin.dashboard');
    }

    public function indexInstitusi(){
        $institution = Institution::all();        
        return view('superadmin.hasilinstitusi', ['institution' => $institution]);
    }

    public function indexPersonal(){
        $users = User::all();
        return view('superadmin.hasilpersonal', ['users' => $users]);
    }

    public function institusiById(Request $request){
        $institution = Institution::all();        
        $institutionbyid = Institution::where('id', $request->institution_id)->get()->first();
        if($institutionbyid === null){
            return redirect('/super-admin/hasil/institusi');
        }
        $survey_institusi_admin = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? GROUP BY sq.dimensi ORDER BY rata DESC', [$request->institution_id]);
        
        return view('superadmin.hasilinstitusi', ['institution' => $institution, 'survey_institusi_admin' => $survey_institusi_admin, 'institutionbyid' => $institutionbyid]);    
        
    }

    public function getInstitusi(Request $request){                    
        $hasil_survey_institusi = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? AND sq.dimensi <> ? GROUP BY sq.dimensi ORDER BY rata DESC', [$request->institution_id, 'risk']);
        return response()->json(['hasil_survey_institusi' => $hasil_survey_institusi] , Response::HTTP_OK);  
    }

    public function personalById(Request $request){
        $users = User::all();        
        $userbyid = User::where('id', $request->user_id)->get()->first();
        if($userbyid === null){
            return redirect('/super-admin/hasil/personal');
        }
        $survey_personal_admin = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? GROUP BY sq.dimensi ORDER BY rata DESC', [$request->user_id]);
        
        return view('superadmin.hasilpersonal', ['users' => $users, 'survey_personal_admin' => $survey_personal_admin, 'userbyid' => $userbyid]);    
        
    }
    public function getPersonal(Request $request){                    
        $hasil_survey_personal = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? AND sq.dimensi <> ? GROUP BY sq.dimensi ORDER BY rata DESC', [$request->user_id, 'risk']);
        return response()->json(['hasil_survey_personal' => $hasil_survey_personal] , Response::HTTP_OK);  
    }

    // ==================================== SOLUSI ====================================
    public function indexSolusi(){
        $solutions = Solutions::all();

        return view('superadmin.solusi', ['solutions' => $solutions]);
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

        return redirect('/super-admin/solusi');

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

        return redirect('/super-admin/solusi');
    }

    public function deleteSolusi(Request $request){
        Solutions::where('id', $request->solutions_id)->delete();
        return redirect('/super-admin/solusi');
    }

    // ==================================== QUESTION ====================================
    public function indexQuestion(){
        $survey_question = SurveyQuestion::all();

        return view('superadmin.question', ['survey_question' => $survey_question]);
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

        return redirect('/super-admin/question');
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
        return redirect('/super-admin/question');
    }

    public function deleteQuestion(Request $request){
        SurveyQuestion::where('id', $request->question_id)->delete();

        return redirect('/super-admin/question');
    }

    // ==================================== INSTITUTION ====================================
    public function indexInstitution(){
        $institutions = Institution::all();

        return view('superadmin.institution', ['institutions' => $institutions]);
    }

    public function createInstitution(Request $request){
        Institution::create([
            'institution_name' => $request->institution_name,
            'institution_code' => $request->institution_code,
            'max_response' => $request->max_response,
        ]);
        return redirect('/super-admin/institution');
    }

    public function updateInstitution(Request $request){
        // echo $request;
        Institution::where('id', $request->institution_id)->update([
            'institution_name' => $request->institution_name,
            'institution_code' => $request->institution_code,
            'max_response' => $request->max_response,
        ]);
        return redirect('/super-admin/institution');
    }

    public function deleteInstitution(Request $request){
        Institution::where('id', $request->institution_id)->delete();
        return redirect('/super-admin/institution');
    }

    // ==================================== USERS ====================================
    public function indexUsers(){
        $users = User::all();

        return view('superadmin.users', ['users' => $users]);
    }

    public function updateAdmin(Request $request){
        $is_admin = $request->is_admin;
        $userid = $request->userid;

        if($is_admin){
            User::where('id', $userid)->update([
                'is_admin' => 0
            ]);
        }
        else{
            User::where('id', $userid)->update([
                'is_admin' => 1
            ]);
        }

        return redirect('/super-admin/users');
    }

    // ==================================== CATEGORY QUESTION ====================================
    public function indexCategoryQuestion(){
        $survey_category = SurveyCategory::all();

        return view('superadmin.questioncategory', ['survey_category' => $survey_category]);
    }

    public function createCategoryQuestion(Request $request){
        // echo $request->option_1;
        SurveyCategory::create([
            'nama' => $request->nama
        ]);
        $success = "Berhasil menambahkan data category question";
        return redirect('/super-admin/category-question')->with(['success' => $success]);
    }

    public function updateCategoryQuestion(Request $request){
        SurveyCategory::where('id', $request->category_id)->update([
            'nama' => $request->nama
        ]);

        $success = "Berhasil update data category question";
        return redirect('/super-admin/category-question')->with(['success' => $success]);
    }

    public function deleteCategoryQuestion(Request $request){
        SurveyCategory::where('id', $request->category_id)->delete();

        $success = "Berhasil delete data category question";
        return redirect('/super-admin/category-question')->with(['success' => $success]);
    }
}

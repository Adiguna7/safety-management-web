<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institution;
use App\Solutions;
use App\SurveyQuestion;
use App\SurveyQuestionGroup;
use App\SurveyCategory;
use App\Pembobotan;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\map;

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
        $users = User::join('institution', 'institution.id', 'users.institution_id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.role',
                    'users.is_admin',
                    'users.institution_id',

                    'institution.institution_name as institution'
                )
                ->get();
        return view('superadmin.hasilpersonal', ['users' => $users]);
    }

    public function institusiById(Request $request){
        if(Auth::user()->role != "super_admin" && Auth::user()->institution_id != $request->institution_id){
            return abort(403);
        }
        $institution = Institution::all();        
        $institutionbyid = Institution::where('id', $request->institution_id)->get()->first();
        if(empty($institutionbyid)){
            $error = "Institusi/Company tidak ditemukan";
            return redirect('/super-admin/hasil/institusi')->with(["error" => $error]);
        }
        $survey_institusi_admin = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? GROUP BY sq.dimensi ORDER BY rata DESC', [$request->institution_id]);
        if(empty($survey_institusi_admin)){
            $error = "Users institusi/company " . $institutionbyid->institution_name . " belum ada yang mengisi survey";
            return redirect('/super-admin/hasil/institusi')->with(["error" => $error]);
        }
        
        return view('superadmin.hasilinstitusi', ['institution' => $institution, 'survey_institusi_admin' => $survey_institusi_admin, 'institutionbyid' => $institutionbyid]);    
        
    }

    public function getInstitusi(Request $request){                    
        $hasil_survey_institusi = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.institution_id = ? AND sq.dimensi <> ? GROUP BY sq.dimensi ORDER BY rata DESC', [$request->institution_id, 'risk']);
        return response()->json(['hasil_survey_institusi' => $hasil_survey_institusi] , Response::HTTP_OK);  
    }

    public function personalById(Request $request){
        $users = User::all();        
        $userbyid = User::where('id', $request->user_id)->get()->first();
        if(Auth::user()->id == $request->user_id){
            return abort(403);
        }
        if(Auth::user()->role != "super_admin" && Auth::user()->institution_id != $userbyid->institution_id){
            return abort(403);
        }
        if(empty($userbyid)){
            $error = "User tidak ditemukan";
            return redirect('/super-admin/hasil/personal')->with(["error" => $error]);
        }
        $survey_personal_admin = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? GROUP BY sq.dimensi ORDER BY rata DESC', [$request->user_id]);

        if(empty($survey_personal_admin)){
            $error = "User " . $userbyid->name . " belum mengisi survey";
            return redirect('/super-admin/hasil/personal')->with(["error" => $error]);
        }
        
        return view('superadmin.hasilpersonal', ['users' => $users, 'survey_personal_admin' => $survey_personal_admin, 'userbyid' => $userbyid]);    
        
    }
    public function getPersonal(Request $request){                    
        $hasil_survey_personal = DB::select('SELECT avg(sr.answer) AS rata, sq.dimensi FROM survey_response sr, survey_question sq WHERE sr.question_id = sq.id AND sr.user_id = ? AND sq.dimensi <> ? GROUP BY sq.dimensi ORDER BY rata DESC', [$request->user_id, 'risk']);
        return response()->json(['hasil_survey_personal' => $hasil_survey_personal] , Response::HTTP_OK);  
    }

    // ==================================== ADMIN PERUSAHAAN (HANYA VIEW) ====================================
    public function indexAdminPerusahaan(){
        return view('admin.dashboard');
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
        // $survey_question = SurveyQuestion::all();
        $survey_category = SurveyCategory::all();

        $survey_question = SurveyQuestion::join('survey_category', 'survey_category.id', 'survey_question.category_id')
                                    ->select(
                                        'survey_question.id',
                                        'survey_question.dimensi',
                                        'survey_question.category_id',
                                        'survey_question.no_question',
                                        'survey_question.keyword',
                                        'survey_question.text_question',
                                        'survey_question.option_1',
                                        'survey_question.option_2',
                                        'survey_question.option_3',
                                        'survey_question.option_4',
                                        'survey_question.option_5',

                                        'survey_category.nama as category'
                                    )->get();
        return view('superadmin.question', ['survey_question' => $survey_question, 'survey_category' => $survey_category]);
    }

    public function createQuestion(Request $request){
        // echo $request->option_1;
        SurveyQuestion::create([
            'dimensi' => $request->dimensi,
            'category_id' => $request->category,
            'no_question' => $request->no_question,
            'keyword' => $request->keyword,
            'text_question' => $request->text_question,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'option_5' => $request->option_5,
        ]);

        $success = "Berhasil menambah data question";
        return redirect('/super-admin/question')->with(["success" => $success]);
    }

    public function updateQuestion(Request $request){
        SurveyQuestion::where('id', $request->question_id)->update([
            'dimensi' => $request->dimensi,
            'category_id' => $request->category,
            'no_question' => $request->no_question,
            'keyword' => $request->keyword,
            'text_question' => $request->text_question,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'option_5' => $request->option_5,
        ]);

        $success = "Berhasil update data question";
        return redirect('/super-admin/question')->with(["success" => $success]);
    }

    public function deleteQuestion(Request $request){
        SurveyQuestion::where('id', $request->question_id)->delete();

        $success = "Berhasil delete data question";
        return redirect('/super-admin/question')->with(["success" => $success]);
    }

    // ==================================== QUESTION GROUP====================================
    public function indexQuestionGroup(){
        // $survey_question = SurveyQuestion::all();
        $survey_category = SurveyCategory::all();

        $survey_question = SurveyQuestion::join('survey_category', 'survey_category.id', 'survey_question.category_id')
                                    ->select(
                                        'survey_question.id',
                                        'survey_question.dimensi',
                                        'survey_question.category_id',
                                        'survey_question.no_question',
                                        'survey_question.keyword',
                                        'survey_question.text_question',
                                        'survey_question.option_1',
                                        'survey_question.option_2',
                                        'survey_question.option_3',
                                        'survey_question.option_4',
                                        'survey_question.option_5',

                                        'survey_category.nama as category'
                                    )->get();
        $institution = Institution::all();
        return view('superadmin.questiongroup', ['survey_question' => $survey_question, 'survey_category' => $survey_category, 'institution' => $institution]);
    }

    public function indexQuestionGroupById(Request $request){
        $institution_id = $request->institution_id;
        $survey_category = SurveyCategory::all();

        $survey_question = SurveyQuestion::join('survey_category', 'survey_category.id', 'survey_question.category_id')
                                    ->select(
                                        'survey_question.id',
                                        'survey_question.dimensi',
                                        'survey_question.category_id',
                                        'survey_question.no_question',
                                        'survey_question.keyword',
                                        'survey_question.text_question',
                                        'survey_question.option_1',
                                        'survey_question.option_2',
                                        'survey_question.option_3',
                                        'survey_question.option_4',
                                        'survey_question.option_5',

                                        'survey_category.nama as category'
                                    )->get();
        $institution = Institution::all();        
        $survey_question_group = SurveyQuestionGroup::join('institution', 'institution.id', 'survey_group_question.institution_id')        
                                ->join('survey_category', 'survey_category.id', 'survey_group_question.category_id')
                                ->where('institution_id', $institution_id)
                                ->select(
                                    'survey_group_question.id',
                                    'survey_group_question.dimensi',
                                    'survey_group_question.category_id',
                                    'survey_group_question.no_question',
                                    'survey_group_question.keyword',
                                    'survey_group_question.text_question',
                                    'survey_group_question.option_1',
                                    'survey_group_question.option_2',
                                    'survey_group_question.option_3',
                                    'survey_group_question.option_4',
                                    'survey_group_question.option_5',

                                    'survey_category.nama as category',
                                    'survey_group_question.institution_id',
                                    'institution.institution_name as institution'
                                )
                                ->get();
        return view('superadmin.questiongroup', ['survey_category' => $survey_category, 'survey_question' => $survey_question, 'institution' => $institution, 'survey_question_group' => $survey_question_group, 'institution_id' => $institution_id]);
    }
    
    public function importQuestionGroup(Request $request){
        // untuk view import (get)
        $institution_id = $request->institution_id;
        $institutionById = Institution::where('id', $institution_id)
                            ->first();
        $surveyQuestionGroupQuestionId = SurveyQuestionGroup::select('survey_question_id')
                                        ->where('institution_id', $institution_id)
                                        ->get();
        // $survey_question = SurveyQuestion::all();
        $survey_category = SurveyCategory::all();

        $survey_question = SurveyQuestion::join('survey_category', 'survey_category.id', 'survey_question.category_id')
                                    ->select(
                                        'survey_question.id',
                                        'survey_question.dimensi',
                                        'survey_question.category_id',
                                        'survey_question.no_question',
                                        'survey_question.keyword',
                                        'survey_question.text_question',
                                        'survey_question.option_1',
                                        'survey_question.option_2',
                                        'survey_question.option_3',
                                        'survey_question.option_4',
                                        'survey_question.option_5',

                                        'survey_category.nama as category'
                                    )->get();  
        
        $survey_question_id_group = array();
        
        foreach ($surveyQuestionGroupQuestionId as $item) {
            array_push($survey_question_id_group, $item->survey_question_id);
        }        

        foreach($survey_question as $item){
            $item->status_import = "no";
            // echo($item->id);
            // echo(" ");
            if(in_array($item->id, $survey_question_id_group)){
                $item->status_import = "yes";
            }
        }                        
        // echo($survey_question);
        return view('superadmin.questiongroupimport', ['survey_question' => $survey_question, 'survey_category' => $survey_category, 'institutionById' => $institutionById]);
    }

    public function importSaveQuestionGroup(Request $request){
        $survey_question_id = $request->survey_question_id;
        $institution_id = $request->institution_id;
        try {
            $institutionById = Institution::where('id', $institution_id)
                            ->first();

            $surveyQuestionById = SurveyQuestion::join('survey_category', 'survey_category.id', 'survey_question.category_id')
                                ->where('survey_question.id', $survey_question_id)
                                ->select(
                                    'survey_question.id',
                                    'survey_question.dimensi',
                                    'survey_question.category_id',
                                    'survey_question.no_question',
                                    'survey_question.keyword',
                                    'survey_question.text_question',
                                    'survey_question.option_1',
                                    'survey_question.option_2',
                                    'survey_question.option_3',
                                    'survey_question.option_4',
                                    'survey_question.option_5',

                                    'survey_category.nama as category'
                                )->first();  
            
            $surveyGroupNoQuestion = 1;

            $surveyQuestionGroupByIdLatest = SurveyQuestionGroup::latest('no_question')->first();            

            if(!empty($surveyQuestionGroupByIdLatest)){
                $surveyGroupNoQuestion = $surveyQuestionGroupByIdLatest->no_question + 1;
            }

            SurveyQuestionGroup::create([
                'dimensi' => $surveyQuestionById->dimensi,
                'category_id' => $surveyQuestionById->category_id,
                'no_question' => $surveyGroupNoQuestion,
                'keyword' => $surveyQuestionById->keyword,
                'text_question' => $surveyQuestionById->text_question,
                'option_1' => $surveyQuestionById->option_1,
                'option_2' => $surveyQuestionById->option_2,
                'option_3' => $surveyQuestionById->option_3,
                'option_4' => $surveyQuestionById->option_4,
                'option_5' => $surveyQuestionById->option_5,
                
                'survey_question_id' => $survey_question_id,
                'institution_id' => $institution_id
            ]);
            
            $success = "Berhasil save import data ke " . $institutionById->institution_name;
            return response()->json(['success' => $success] , Response::HTTP_OK);  
        }
        catch(\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'institution_id' => $institution_id] , Response::HTTP_OK);  
        }        
    }

    public function importCancelQuestionGroup(Request $request){
        $survey_question_id = $request->survey_question_id;
        $institution_id = $request->institution_id;
        try {
            $institutionById = Institution::where('id', $institution_id)
                            ->first();            

            SurveyQuestionGroup::where('institution_id', $institution_id)
                                ->where('survey_question_id', $survey_question_id)
                                ->delete();
            
            $success = "Berhasil cancel import data ke " . $institutionById->institution_name;
            return response()->json(['success' => $success] , Response::HTTP_OK);  
        }
        catch(\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'institution_id' => $institution_id] , Response::HTTP_OK);  
        }        
    }

    public function createQuestionGroup(Request $request){
        $institution_id = $request->institution_id;
        $institutionById = Institution::where('id', $institution_id)
                            ->first();

        try {
            SurveyQuestionGroup::create([
                'dimensi' => $request->dimensi,
                'category_id' => $request->category,
                'no_question' => $request->no_question,
                'keyword' => $request->keyword,
                'text_question' => $request->text_question,
                'option_1' => $request->option_1,
                'option_2' => $request->option_2,
                'option_3' => $request->option_3,
                'option_4' => $request->option_4,
                'option_5' => $request->option_5,

                'institution_id' => $institution_id
            ]);

            $success = "Berhasil menambah data question untuk group " . $institutionById->institution_name;
            return redirect('/super-admin/question-group/' . $institution_id)->with(["success" => $success]);
        }
        catch(\Exception $e)
        {            
            return redirect('/super-admin/question-group/' . $institution_id)->with(["error" => $e->getMessage()]);
        }
    }

    public function updateQuestionGroup(Request $request){
        $institution_id = $request->institution_id;        
        try {
            SurveyQuestionGroup::where('id', $request->question_id)->update([
                'dimensi' => $request->dimensi,
                'category_id' => $request->category,
                'no_question' => $request->no_question,
                'keyword' => $request->keyword,
                'text_question' => $request->text_question,
                'option_1' => $request->option_1,
                'option_2' => $request->option_2,
                'option_3' => $request->option_3,
                'option_4' => $request->option_4,
                'option_5' => $request->option_5,
            ]);

            $institutionById = Institution::where('id', $institution_id)->first();
            $success = "Berhasil update data question group " . $institutionById->institution_name;
            return redirect('/super-admin/question-group/'.$institution_id)->with(["success" => $success]);
        }     
        catch(\Exception $e)
        {            
            return redirect('/super-admin/question-group/' . $institution_id)->with(["error" => $e->getMessage()]);
        }   
        
    }

    public function deleteQuestionGroup(Request $request){
        $institution_id = $request->institution_id;

        try {

            SurveyQuestionGroup::where('id', $request->question_id)->delete();
            $institutionById = Institution::where('id', $institution_id)->first();
            $success = "Berhasil delete data question group " . $institutionById->institution_name;
            return redirect('/super-admin/question-group/'.$institution_id)->with(["success" => $success]);

        } catch (\Exception $e) {
            return redirect('/super-admin/question-group/' . $institution_id)->with(["error" => $e->getMessage()]);
        }        
    }

    // public function getAllSurveyQuestionQuestionGroup(){
    //     // $survey_question = Su
    // }
    // public function createQuestion(Request $request){
    //     // echo $request->option_1;
    //     SurveyQuestion::create([
    //         'dimensi' => $request->dimensi,
    //         'category_id' => $request->category,
    //         'no_question' => $request->no_question,
    //         'keyword' => $request->keyword,
    //         'text_question' => $request->text_question,
    //         'option_1' => $request->option_1,
    //         'option_2' => $request->option_2,
    //         'option_3' => $request->option_3,
    //         'option_4' => $request->option_4,
    //         'option_5' => $request->option_5,
    //     ]);

    //     $success = "Berhasil menambah data question";
    //     return redirect('/super-admin/question')->with(["success" => $success]);
    // }

    // public function updateQuestion(Request $request){
    //     SurveyQuestion::where('id', $request->question_id)->update([
    //         'dimensi' => $request->dimensi,
    //         'category_id' => $request->category,
    //         'no_question' => $request->no_question,
    //         'keyword' => $request->keyword,
    //         'text_question' => $request->text_question,
    //         'option_1' => $request->option_1,
    //         'option_2' => $request->option_2,
    //         'option_3' => $request->option_3,
    //         'option_4' => $request->option_4,
    //         'option_5' => $request->option_5,
    //     ]);

    //     $success = "Berhasil update data question";
    //     return redirect('/super-admin/question')->with(["success" => $success]);
    // }

    // public function deleteQuestion(Request $request){
    //     SurveyQuestion::where('id', $request->question_id)->delete();

    //     $success = "Berhasil delete data question";
    //     return redirect('/super-admin/question')->with(["success" => $success]);
    // }

    // ==================================== INSTITUTION ====================================
    public function indexInstitution(){
        $institutions = Institution::all();

        return view('superadmin.institution', ['institutions' => $institutions]);
    }

    public function createInstitution(Request $request){
        $createPembobotan = false;
        try {   
            if($request->category == "expert"){
                $institutionParentById = Institution::where('id', $request->parent_id)->first();
                if(empty($institutionParentById)){    
                    $error = "Institusi / Perusahaan parent tidak ditemukan";
                    return redirect('/super-admin/institution')->with(["error" => $error]);
                }
                if($institutionParentById->category == "expert" || $institutionParentById->category == "umum"){
                    $error = "Request tidak bisa dilakukan karena expert tidak disambungkan ke institusi / perusahaan";
                    return redirect('/super-admin/institution')->with(["error" => $error]);
                }
                $institutionChildById = Institution::where('parent_id', $request->parent_id)->first();
                if(!empty($institutionChildById)){
                    $error = "Expert tiap institusi/perusahaan hanya ada 1 role";
                    return redirect('/super-admin/institution')->with(["error" => $error]);
                }
                $createPembobotan = true;
            }                         
            if($createPembobotan){
                $pembobotan = Pembobotan::where('institution_id', $request->parent_id)->first();
                
                if(empty($pembobotan)){
                    Pembobotan::create([
                        'institution_id' => $request->parent_id,                        
                    ]);
                }
            }
            Institution::create([
                'institution_name' => $request->institution_name,
                'institution_code' => $request->institution_code,
                'category' => $request->category,
                'max_response' => $request->max_response,
                'parent_id' => $request->parent_id
            ]);
            $success = "Berhasil menambahkan institusi / perusahaan";
            return redirect('/super-admin/institution')->with(["success" => $success]);
        }catch (\Exception $e) {
            return redirect('/super-admin/institution')->with(["error" => $e->getMessage()]);
        }        
    }

    public function updateInstitution(Request $request){
        if($request->category == "expert"){
            $institutionParentById = Institution::where('id', $request->parent_id)->first();
            if(empty($institutionParentById)){    
                $error = "Institusi / Perusahaan parent tidak ditemukan";
                return redirect('/super-admin/institution')->with(["error" => $error]);
            }
            if($institutionParentById->category == "expert" || $institutionParentById->category == "umum"){
                $error = "Request tidak bisa dilakukan karena expert tidak disambungkan ke institusi / perusahaan";
                return redirect('/super-admin/institution')->with(["error" => $error]);
            }
        }
        try{
            Institution::where('id', $request->institution_id)->update([
                'institution_name' => $request->institution_name,
                'institution_code' => $request->institution_code,                
                'category' => $request->category,
                'max_response' => $request->max_response,
                'parent_id' => $request->parent_id
            ]);
            $success = "Berhasil update institusi / perusahaan";
            return redirect('/super-admin/institution')->with(["success" => $success]);
        }catch (\Exception $e) {
            return redirect('/super-admin/institution')->with(["error" => $e->getMessage()]);
        }        
    }

    public function deleteInstitution(Request $request){
        try{
            Institution::where('id', $request->institution_id)->delete();
            $success = "Berhasil delete institusi / perusahaan";
            return redirect('/super-admin/institution')->with(["success" => $success]);
        }       
        catch (\Exception $e) {
            return redirect('/super-admin/institution')->with(["error" => $e->getMessage()]);
        } 
    }

    // ==================================== USERS ====================================
    public function indexUsers(){
        $users = User::join('institution', 'institution.id', 'users.institution_id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.role',
                    'users.is_admin',
                    'users.institution_id',
                    'users.created_at',

                    'institution.institution_name as institution'
                )                
                ->get();

        $institution = Institution::all();        
        return view('superadmin.users', ['users' => $users, 'institution' => $institution]);
    }

    public function updateAdmin(Request $request){
        $userid = $request->userid;
        $is_admin = false;    
        $role = $request->role;    
        switch ($role) {
            case 'super_admin':
                $is_admin = true;                
                break;
            case 'admin':
                $is_admin = true;                
                break;                    
        }                

        User::where('id', $userid)->update([
            'is_admin' => $is_admin,
            'role' => $role
        ]);
        
        $success = "Berhasil update data user";
        return redirect('/super-admin/users')->with(["success" => $success]);
    }

    public function updateUserInstitution(Request $request){
        $userid = $request->userid;        
        $institution_id = $request->institution_id;                

        User::where('id', $userid)->update([
            'institution_id' => $institution_id
        ]);
        
        $success = "Berhasil update data institution user";
        return redirect('/super-admin/users')->with(["success" => $success]);
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

    // ==================================== PEMBOBOTAN ====================================
    public function indexPembobotan(){
        $pembobotan = Pembobotan::join('institution', 'institution.id', 'pembobotan.institution_id')
                    ->select(
                        'pembobotan.id',
                        'pembobotan.nilai_expert',
                        'pembobotan.nilai_users',
                        'pembobotan.institution_id',

                        'institution.institution_name as institution'
                    )
                    ->get();
        $institutions = Institution::all();

        return view('superadmin.pembobotan', ['pembobotan' => $pembobotan, 'institutions' => $institutions]);
    }

    // public function createInstitution(Request $request){
    //     if($request->category == "expert"){
    //         $institutionParentById = Institution::where('id', $request->parent_id)->first();
    //         if(empty($institutionParentById)){    
    //             $error = "Institusi / Perusahaan parent tidak ditemukan";
    //             return redirect('/super-admin/institution')->with(["error" => $error]);
    //         }
    //         if($institutionParentById->category == "expert" || $institutionParentById->category == "umum"){
    //             $error = "Request tidak bisa dilakukan karena expert tidak disambungkan ke institusi / perusahaan";
    //             return redirect('/super-admin/institution')->with(["error" => $error]);
    //         }

    //     }        
    //     try {
    //         Institution::create([
    //             'institution_name' => $request->institution_name,
    //             'institution_code' => $request->institution_code,
    //             'category' => $request->category,
    //             'max_response' => $request->max_response,
    //             'parent_id' => $request->parent_id
    //         ]);
    //         $success = "Berhasil menambahkan institusi / perusahaan";
    //         return redirect('/super-admin/institution')->with(["success" => $success]);
    //     }catch (\Exception $e) {
    //         return redirect('/super-admin/institution')->with(["error" => $e->getMessage()]);
    //     }        
    // }

    public function updatePembobotan(Request $request){        
        try{
            $nilai_expert = (int)$request->nilai_expert;
            $nilai_users = 100 - $nilai_expert;

            Pembobotan::where('id', $request->pembobotan_id)->update([
                'nilai_expert' => $nilai_expert,                
                'nilai_users' =>$nilai_users,                
            ]);
            $success = "Berhasil update pembobotan institusi / perusahan";
            return redirect('/super-admin/pembobotan')->with(["success" => $success]);
        }catch (\Exception $e) {
            return redirect('/super-admin/pembobotan')->with(["error" => $e->getMessage()]);
        }        
    }

    // public function deleteInstitution(Request $request){
    //     try{
    //         Institution::where('id', $request->institution_id)->delete();
    //         $success = "Berhasil delete institusi / perusahaan";
    //         return redirect('/super-admin/institution')->with(["success" => $success]);
    //     }       
    //     catch (\Exception $e) {
    //         return redirect('/super-admin/institution')->with(["error" => $e->getMessage()]);
    //     } 
    // }
}

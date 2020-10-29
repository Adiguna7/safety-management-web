<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institution;
use App\User;
use Illuminate\Support\Facades\DB;
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
}

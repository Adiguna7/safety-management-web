@extends('layouts.superadmindashboard')

@section('header')
Hasil Personal
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">        
        <div class="form-group">
            <label for="institution">Select User</label>
            <select class="form-control" id="user" name="user_id" onchange="window.location.href='/super-admin/hasil/personal/' + this.value">
                <option disabled selected>Nama User</option>
                @foreach ($users as $user)                    
                    @if($user->id == Auth::user()->id)
                        @continue
                    @endif                    
                    @if(Auth::user()->role != "super_admin" && Auth::user()->institution_id != $user->institution_id)
                        @continue
                    @endif
                    <option value="{{ $user->id }}" @if(!empty($userbyid) && $userbyid->id == $user->id) selected @endif>{{ $user->name . " - " . $user->institution}}</option>                    
                @endforeach                                
            </select>
        </div>        
    </div>
</div>

@if (isset($survey_personal_admin))
<div class="row mt-5">
    <div class="col-lg-4">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">            
            <div class="card-body">
                <h5 class="card-title font-weight-bold text-center">Nama: {{ $userbyid->name }}</h5>                                    
                <table class="table">
                    <thead>                    
                      <tr>
                        <th scope="col">Dimensi</th>
                        <th scope="col">Score</th>                        
                      </tr>                    
                    </thead>
                    <tbody>
                    @foreach ($survey_personal_admin as $hasil)       
                      <tr>
                        <th scope="row">{{strtoupper($hasil->dimensi)}}</th>
                        <td>{{$hasil->rata}}</td>                        
                      </tr>
                    @endforeach                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div id="mynetwork">            
        </div>
    </div>
</div>


{{-- visjs --}}
<script src="{{ asset('js/vis.min.js') }}"></script>
<script src="{{ asset('js/index4.js') }}"></script>
@endif
@endsection
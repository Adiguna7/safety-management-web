@extends('layouts.superadmindashboard')

@section('header')
Hasil Personal
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">        
        <div class="form-group">
            <label for="institution">Select User</label>
            <select class="form-control" id="institution" name="institution_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @if(isset($userbyid) && $userbyid->id === $user->id) selected @endif>{{ $user->name }}</option>
                @endforeach                                
            </select>
        </div>
        <button class="btn btn-info" onclick="window.location.href='/super-admin/hasil/personal/'+document.getElementById('institution').value">Select</button>        
    </div>
</div>

@if (isset($survey_personal_admin))
<div class="row mt-5">
    <div class="col-lg-4">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">            
            <div class="card-body">
                <h5 class="card-title font-weight-bold">Nama: {{ $userbyid->name }}</h5>                                    
                @foreach ($survey_personal_admin as $hasil)
                    <p class="card-text">{{ $hasil->dimensi }}<span>: {{ $hasil->rata }}</span></p>
                @endforeach
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
@extends('layouts.superadmindashboard')

@section('header')
Hasil Institusi
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">        
        <div class="form-group">
            <label for="institution">Select Institution</label>
            <select class="form-control" id="institution" name="institution_id">
                <option selected disabled>Nama Institusi / Company</option>
                @foreach ($institution as $institut)
                    @if(Auth::user()->role != "super_admin" && Auth::user()->institution_id != $institut->id){
                        @continue
                    }
                    @endif
                    <option value="{{ $institut->id }}" @if(!empty($institutionbyid->id) && $institutionbyid->id == $institut->id) selected @endif>{{ $institut->institution_name }}</option>
                @endforeach                                
            </select>
        </div>
        <button class="btn btn-info" onclick="window.location.href='/super-admin/hasil/institusi/'+document.getElementById('institution').value">Select</button>        
    </div>
</div>

@if (isset($survey_institusi_admin))
<div class="row mt-5">
    <div class="col-lg-4">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">            
            <div class="card-body">
                <h5 class="card-title font-weight-bold">Nama Institusi: {{ $institutionbyid->institution_name }}</h5>                                    
                <table class="table">
                    <thead>                    
                      <tr>
                        <th scope="col">Dimensi</th>
                        <th scope="col">Score</th>                        
                      </tr>                    
                    </thead>
                    <tbody>
                    @foreach ($survey_institusi_admin as $hasil)       
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
<script src="{{ asset('js/index3.js') }}"></script>
@endif
@endsection
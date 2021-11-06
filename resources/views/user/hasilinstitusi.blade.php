@extends('layouts.userdashboard')

@section('header')
Hasil Survey Institusi/Company
@endsection

@section('content')
@if(!empty($hasil_survey_institusi))
<div class="row mt-5">
    <div class="col-lg-4">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">            
            <div class="card-body">
                <h5 class="card-title font-weight-bold text-center">Nama Institusi/Company: <b>{{ $data_institution->institution_name }}</b></h5>                                    
                <table class="table">
                    <thead>                    
                      <tr>
                        <th scope="col">Dimensi</th>
                        <th scope="col">Score</th>                        
                      </tr>                    
                    </thead>
                    <tbody>
                    @foreach ($hasil_survey_institusi as $hasil)       
                      <tr>
                        <th scope="row">{{strtoupper($hasil->dimensi)}}</th>
                        <td>{{$hasil->rata}}</td>                        
                      </tr>
                    @endforeach                      
                    </tbody>
                </table>
                {{-- @foreach ($hasil_survey_institusi as $hasil)
                    <p class="card-text">{{ $hasil->dimensi }}<span>: {{ $hasil->rata }}</span></p>
                    @if($loop->index == 0)
                        <hr/>
                    @endif
                @endforeach --}}
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div id="mynetwork" style="overflow-y: hidden">            
        </div>
    </div>
</div>
@else
<div class="alert alert-danger" role="alert">
    User dari institusi anda belum ada yang mengisi survey
</div>
@endif


{{-- visjs --}}
<script src="{{ asset('js/vis.min.js') }}"></script>
<script src="{{ asset('js/index2.js') }}"></script>

@endsection
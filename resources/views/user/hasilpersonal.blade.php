@extends('layouts.userdashboard')

@section('header')
Hasil Survey Personal
@endsection

@section('content')
@if(!empty($hasil_survey))
<div class="row mt-5">
    <div class="col-lg-4">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">                       
            <div class="card-body">              
                <h5 class="card-title font-weight-bold text-center">Nama : <b>{{ $user->name }}</b></h5>                                                                     
                <table class="table">
                    <thead>                    
                      <tr>
                        <th scope="col">Dimensi</th>
                        <th scope="col">Score</th>                        
                      </tr>                    
                    </thead>
                    <tbody>
                    @foreach ($hasil_survey as $hasil)       
                      <tr>
                        <th scope="row">{{strtoupper($hasil->dimensi)}}</th>
                        <td>{{$hasil->rata}}</td>                        
                      </tr>
                    @endforeach                      
                    </tbody>
                </table>
                {{-- @foreach ($hasil_survey as $hasil)                                                            
                    <p class="card-text">{{ $hasil->dimensi }}<span>: {{ $hasil->rata }}</span></p>                    
                    @if($loop->index == 0)
                        <hr/>
                    @endif                    
                @endforeach                   --}}
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div id="mynetwork">
            {{-- <img src="{{ asset('img/safetymodel.png') }}" alt="" srcset="" class="img-fluid"> --}}
        </div>
    </div>
</div>
@else
<div class="alert alert-danger" role="alert">
    Anda belum mengisi survey
</div>
@endif


{{-- visjs --}}
<script src="{{ asset('js/vis.min.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>

@endsection
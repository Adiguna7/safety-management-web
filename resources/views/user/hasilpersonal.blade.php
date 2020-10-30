@extends('layouts.userdashboard')

@section('header')
Hasil Survey Personal
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-lg-4">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">                       
            <div class="card-body">              
                <h5 class="card-title font-weight-bold">Nama : {{ $user->name }}</h5>                                     
                @foreach ($hasil_survey as $hasil)
                    <p class="card-text">{{ $hasil->dimensi }}<span>: {{ $hasil->rata }}</span></p>
                @endforeach                  
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div id="mynetwork">
            {{-- <img src="{{ asset('img/safetymodel.png') }}" alt="" srcset="" class="img-fluid"> --}}
        </div>
    </div>
</div>


{{-- visjs --}}
<script src="{{ asset('js/vis.min.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>

@endsection
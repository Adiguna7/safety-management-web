@extends('layouts.userdashboard')

@section('header')
Hasil Survey Institusi
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-lg-4">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">            
            <div class="card-body">
                <h5 class="card-title font-weight-bold">Nama Institusi: {{ $data_institution->institution_name }}</h5>                                    
                @foreach ($hasil_survey_institusi as $hasil)
                    <p class="card-text">{{ $hasil->dimensi }}<span>: {{ $hasil->rata }}</span></p>
                    @if($loop->index == 0)
                        <hr/>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div id="mynetwork" style="overflow-y: hidden">            
        </div>
    </div>
</div>


{{-- visjs --}}
<script src="{{ asset('js/vis.min.js') }}"></script>
<script src="{{ asset('js/index2.js') }}"></script>

@endsection
@extends('layouts.userdashboardfull')

@section('header')
Hasil Survey Personal
@endsection

@section('content')
@if(!$hasil_survey->isEmpty())
<div class="row mt-5 justify-content-center">
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
    <div class="col-lg-5 d-flex justify-content-center">
        <div id="mynetwork">
            {{-- <img src="{{ asset('img/safetymodel.png') }}" alt="" srcset="" class="img-fluid"> --}}
        </div>
    </div>
</div>

@if(!$altSolusi->isEmpty())
<div class="row mt-3">    
    <div class="col-lg-12">
        <h5>Alternatif Solusi Terpilih</h5>
    </div>
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>                                                       
                  <th>Tahun</th>   
                  <th>Author</th>       
                  <th>Background Perusahaan</th>                              
                  <th>Dimensi</th>
                  <th>Doi.</th>
                  <th>Key Success</th>                        
                </tr>
              </thead>
              <tbody>
                  @foreach($altSolusi as $item)
                  <tr>                    
                    <td>{{ $item->tahun }}</td>
                    <td>{{ $item->author }}</td>
                    <td>{{ $item->company_background }}</td>
                    <td>{{ $item->dimensi }}</td>
                    <td><a href="{{ $item->link_doi }}">{{ $item->link_doi }}</a></td>
                    <td>{{ $item->solution }}</td>                                        
                  </tr>
                  @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="alert alert-danger" role="alert">
    Belum memilih alternatif solusi
</div>
@endif
@else
<div class="alert alert-danger" role="alert">
    Anda belum mengisi survey
</div>
@endif


{{-- visjs --}}
<script src="{{ asset('js/vis.min.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>

@endsection
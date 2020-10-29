@extends('layouts.admindashboard')

@section('header')
Dashboard Admin
@endsection

@section('content')
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body d-flex flex-column justify-content-between">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Hasil Survey Group</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2">Lihat hasil survey berdasarkan institusi</div>
                  </div>                  
                </div>
                <div class="row no-gutters">
                    <div class="btn btn-info mt-3" onclick="window.location.href='/user/survey'">Lihat Hasil</div>                
                </div>                
              </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body d-flex flex-column justify-content-between">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hasil Survey Personal</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2">Lihat hasil survey berdasarkan individu</div>
                  </div>                  
                </div>
                <div class="row no-gutters">
                    <div class="btn btn-success mt-3" onclick="window.location.href='/user/survey'">Lihat Hasil</div>                
                </div>                
              </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body d-flex flex-column justify-content-between">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Alternatif Solusi</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2">Tambah, Edit, Hapus alternatif solusi</div>
                  </div>                  
                </div>                
                <div class="row no-gutters">                                                                                 
                    <button class="btn btn-primary mt-3" onclick="window.location.href='/user/survey'">Alternatif Solusi</button>                                                            
                </div>                
              </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
              <div class="card-body d-flex flex-column justify-content-between">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Survey Question</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2">Tambah, Edit, Hapus pertanyaan survey</div>
                  </div>                  
                </div>
                <div class="row no-gutters">
                    <div class="btn btn-warning mt-3" onclick="window.location.href='/user/survey'">Survey Question</div>                
                </div>                
              </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->        

    </div>
@endsection


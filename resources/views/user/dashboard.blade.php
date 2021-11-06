@extends('layouts.userdashboard')

@section('header')
User Dashboard
@endsection

@section('content')    
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body d-flex flex-column justify-content-between">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Isi Survey</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2">Isi survey tentang management safety institusi anda</div>
                  </div>                  
                </div>                
                <div class="row no-gutters">
                    @if(isset($checkresponse))                        
                        <small class="text-primary">*Anda sudah mengisi survey</small>                        
                        <button class="btn btn-primary mt-3" onclick="window.location.href='/user/survey'">Isi Lagi</button>                                                                
                    @else
                        <button class="btn btn-primary mt-3" onclick="window.location.href='/user/survey'">Isi Survey</button>                                        
                    @endif                    
                </div>                
              </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body d-flex flex-column justify-content-between">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Lihat Hasil Survey</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2">Lihat hasil survey anda</div>
                  </div>                  
                </div>
                <div class="row no-gutters">
                    <div class="btn btn-success mt-3" onclick="window.location.href='/survey/hasil/personal'">Lihat Hasil</div>
                </div>                
              </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body d-flex flex-column justify-content-between">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Lihat Hasil Survey</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2">Lihat hasil survey institusi anda</div>
                  </div>                  
                </div>
                <div class="row no-gutters">
                  
                    <div class="btn btn-info mt-3" onclick="window.location.href='/survey/hasil/institusi'">Lihat Hasil</div>                
                </div>                
              </div>
            </div>
        </div>
    </div>
@endsection
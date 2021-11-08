@extends('layouts.userdashboard')

@section('header')
Alternatif Solusi
@endsection

@section('content')
@if(!empty($scoreUser))
<div class="row">
    <div class="col-lg-12">
        <small class="text-danger">*Alternatif Solusi Untuk Nilai 2 Terbawah Survey Anda</small>
    </div>    
</div>
@if(!empty($first_lowest))
<div class="row mt-3">    
    <div class="col-lg-12">
        <h5>Alternatif Solusi Dimensi {{strtoupper($first_lowest[0]->dimensi)}} (First Lowest)</h5>
    </div>
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTableSolusi1" width="100%" cellspacing="0">
              <thead>
                <tr>                                                       
                  <th>Tahun</th>   
                  <th>Author</th>       
                  <th>Background Perusahaan</th>                              
                  <th>Dimensi</th>
                  <th>Doi.</th>
                  <th>Key Success</th>
                  <th>Keterangan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($first_lowest as $item)
                  <tr>                    
                    <td>{{ $item->tahun }}</td>
                    <td>{{ $item->author }}</td>
                    <td>{{ $item->company_background }}</td>
                    <td>{{ $item->dimensi }}</td>
                    <td><a href="{{ $item->link_doi }}">{{ $item->link_doi }}</a></td>
                    <td>{{ $item->solution }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td id="ButtonImport{{$item->id}}">
                        @if($item->status_import == "no")
                            <button class="btn btn-success" onclick="saveSolutionById({{$item->id}})">Select</button>
                        @elseif($item->status_import == "yes")
                            <button class="btn btn-warning" onclick="deleteSolutionById({{$item->id}})">Cancel</button>
                        @endif
                    </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="alert alert-danger" role="alert">
    Alternatif Solusi Untuk Dimensi Ini Belum Tersedia
</div>
@endif
@if(!empty($second_lowest))
<div class="row mt-5">    
    <div class="col-lg-12">
        <h5>Alternatif Solusi Dimensi {{strtoupper($second_lowest[0]->dimensi)}} (Second Lowest)</h5>
    </div>
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTableSolusi2" width="100%" cellspacing="0">
              <thead>
                <tr>                                                                           
                    <th>Tahun</th>   
                    <th>Author</th>       
                    <th>Background Perusahaan</th>                              
                    <th>Dimensi</th>
                    <th>Doi.</th>
                    <th>Key Success</th>
                    <th>Keterangan</th>            
                    <th>Action</th>        
                </tr>
              </thead>
              <tbody>
                @foreach($second_lowest as $item)
                  <tr>                    
                    <td>{{ $item->tahun }}</td>
                    <td>{{ $item->author }}</td>
                    <td>{{ $item->company_background }}</td>
                    <td>{{ $item->dimensi }}</td>
                    <td><a href="{{ $item->link_doi }}">{{ $item->link_doi }}</a></td>
                    <td>{{ $item->solution }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td id="ButtonImport{{$item->id}}">
                        @if($item->status_import == "no")
                            <button class="btn btn-success" onclick="saveSolutionById({{$item->id}})">Select</button>
                        @elseif($item->status_import == "yes")
                            <button class="btn btn-warning" onclick="deleteSolutionById({{$item->id}})">Cancel</button>
                        @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="alert alert-danger" role="alert">
    Alternatif Solusi Untuk Dimensi Ini Belum Tersedia
</div>
@endif
@else
<div class="alert alert-danger" role="alert">
    Silahkan Mengisi Survey Terlebih Dahulu
</div>
@endif


<script src="{{ asset('js/savesolution.js') }}"></script>
@endsection
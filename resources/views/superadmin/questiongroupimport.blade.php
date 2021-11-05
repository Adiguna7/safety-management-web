@extends('layouts.superadmindashboard')

@section('header')
Import Data Survey Question Group 
@if(isset($institutionById) && !empty($institutionById))
    {{$institutionById->institution_name}}
@endif
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
      <button class="btn btn-info mb-3" onclick="window.location.href='/super-admin/question-group/{{$institutionById->id}}'"><i class="fas fa-arrow-left"></i> Back</button>
  </div>
</div>
<div class="row" style="min-height: 100vh">    
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Dimensi</th>
                  <th>Category</th>
                  <th>No Question</th>
                  <th>Keyword</th>
                  <th>Question</th>
                  <th>Option1</th>
                  <th>Option2</th>                  
                  <th>Option3</th>                  
                  <th>Option4</th>                  
                  <th>Option5</th>                                    
                  <th>Import</th>                  
                </tr>
              </thead>              
              <tbody>
                @foreach ($survey_question as $item)                                
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->dimensi }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->no_question }}</td>
                    <td>{{ $item->keyword }}</td>
                    <td>{{ $item->text_question }}</td>
                    <td>{{ $item->option_1 }}</td>
                    <td>{{ $item->option_2 }}</td>
                    <td>{{ $item->option_3 }}</td>
                    <td>{{ $item->option_4 }}</td>
                    <td>{{ $item->option_5 }}</td>      
                    {{-- <td>{{$item->status_import}}</td> --}}
                    <td id="ButtonImport{{$item->id}}">                      
                      @if($item->status_import == "yes")
                      <button class="btn btn-warning" onclick="cancelImportDataById({{$item->id}}, {{$institutionById->id}})">Cancel</button>
                      @else
                      <button class="btn btn-info" onclick="saveImportDataById({{$item->id}}, {{$institutionById->id}})">Import</button>                                                                                                                                                                                         
                      @endif
                    </td>
                </div>
                </tr>
                @endforeach
              </tbody>            
            </table>        
    </div>
</div>  


<script src="{{ asset('js/importdata.js') }}"></script>
@endsection
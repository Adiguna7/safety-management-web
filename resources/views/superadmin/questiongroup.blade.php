@extends('layouts.superadmindashboard')

@section('header')
Data Survey Question Group
    @foreach($institution as $item)
        @if(!empty($institution_id) && $item->id == $institution_id)
            {{$item->institution_name}}
        @endif
    @endforeach
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">        
        <div class="form-group">
            <label for="institution">Select Institution</label>
            <select class="form-control" id="institution" name="institution_id" onchange="window.location.href='/super-admin/question-group/' + this.value">
                <option disabled selected>Institution/Company</option>
                @foreach ($institution as $institut)         
                    @if(Auth::user()->role != "super_admin" && Auth::user()->institution_id != $institut->id)
                        @continue
                    @endif
                    <option id="institution_id" value="{{ $institut->id }}" @if(!empty($institution_id) && $institution_id == $institut->id) selected @endif>{{ $institut->institution_name }}</option>
                @endforeach                                
            </select>
        </div>        
    </div>
</div>
@if(!empty($survey_question_group))
<div class="row">
    <div class="col-lg-12">
        <button class="btn btn-info mb-3" data-toggle="modal" data-target="#createdataModal">Create Data</button>
        <button class="btn btn-info mb-3" data-toggle="modal" data-target="#importdataModal" onclick="window.location.href='{{url('/super-admin/question-group/import/'.$institution_id)}}'">Import Data</button>

        <!-- Modal Create Data -->
        <div class="modal fade" id="createdataModal" tabindex="-1" role="dialog" aria-labelledby="createdataModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Survey Question Group
                    @foreach($institution as $item)
                        @if(!empty($institution_id) && $item->id == $institution_id)
                            {{$item->institution_name}}
                        @endif
                    @endforeach
                </h5>                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="/super-admin/question-group/create" method="post">
                    @csrf
                    <input type="hidden" name="institution_id" value="{{$institution_id}}">
                    <div class="modal-body">                    
                        <div class="form-group">                                                
                            <select class="form-control" required name="dimensi">
                                <option disabled selected>Dimensi ...</option>
                                <option value="1">Commitment</option>
                                <option value="2">Leadership</option>
                                <option value="3">Responsibility</option>
                                <option value="4">Engagement</option>
                                <option value="5">Risk</option>
                                <option value="6">Competence</option>
                                <option value="7">Information Communication</option>
                                <option value="8">Organizational Learning</option>
                            </select>
                        </div>
                        <div class="form-group">   
                            <select class="form-control" required name="category" id="category">
                                <option disabled selected>Category ...</option>
                                @foreach ($survey_category as $item)<option value="{{$item->id}}" @if(old('category') == $item->id){{"selected"}}@endif>{{$item->nama}}</option>@endforeach                                    
                            <select>                                                 
                        </div>                    
                        <div class="form-group">                        
                            <input required type="number" class="form-control" name="no_question" placeholder="Number Question ...">
                        </div>                    
                        <div class="form-group">                        
                            <input required type="text" class="form-control" name="keyword" placeholder="Keyword ...">
                        </div>
                        <div class="form-group">                        
                            <textarea required type="text" class="form-control" name="text_question" placeholder="Question ..."></textarea>
                        </div>                    
                        <div class="form-group">                        
                            <textarea required type="text" class="form-control" name="option_1" placeholder="Opsi 1 ..."></textarea>
                        </div>
                        <div class="form-group">                        
                            <textarea required type="text" class="form-control" name="option_2" placeholder="Opsi 2 ..."></textarea>
                        </div>                                        
                        <div class="form-group">                        
                            <textarea required type="text" class="form-control" name="option_3" placeholder="Opsi 3 ..."></textarea>
                        </div>                    
                        <div class="form-group">                        
                            <textarea required type="text" class="form-control" name="option_4" placeholder="Opsi 4 ..."></textarea>
                        </div>                    
                        <div class="form-group">                        
                            <textarea required type="text" class="form-control" name="option_5" placeholder="Opsi 5 ..."></textarea>
                        </div>                                                                                    
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Submit</button>
                </form>
                </div>
            </div>
            </div>
        </div>
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
                  <th>Update</th>
                  <th>Delete</th>
                </tr>
              </thead>              
              <tbody>
                @foreach ($survey_question_group as $item)                                
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
                  <td><button class="btn btn-info" data-toggle="modal" data-target="#updatequestionModal{{ $item->id }}">Update</button></td>
                    <!-- Modal Update Data -->
                    <div class="modal fade" id="updatequestionModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updatequestionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="updatedataModalLabel{{ $item->id }}">Update Question No Question  {{ $item->no_question }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="/super-admin/question-group/update" method="post">
                                <input type="hidden" name="institution_id" value="{{ $institution_id }}">
                                <input type="hidden" name="question_id" value="{{ $item->id }}">
                                @csrf
                                <div class="modal-body">                    
                                    <div class="form-group">                                                
                                        <select class="form-control" required name="dimensi">
                                            <option disabled>Dimensi ...</option>
                                            <option value="1" @if($item->dimensi === "commitment" ) selected @endif>Commitment</option>
                                            <option value="2" @if($item->dimensi === "leadership") selected @endif>Leadership</option>
                                            <option value="3" @if($item->dimensi === "responsibility") selected @endif>Responsibility</option>
                                            <option value="4" @if($item->dimensi === "engagement") selected @endif>Engagement</option>
                                            <option value="5" @if($item->dimensi === "risk") selected @endif>Risk</option>
                                            <option value="6" @if($item->dimensi === "competence") selected @endif>Competence</option>
                                            <option value="7" @if($item->dimensi === "informationcommunication") selected @endif>Information Communication</option>
                                            <option value="8" @if($item->dimensi === "organizationallearning") selected @endif>Organizational Learning</option>
                                        </select>
                                    </div>
                                    <div class="form-group">                        
                                        <select class="form-control" required name="category" id="category">
                                            <option disabled selected>Category ...</option>
                                            @foreach ($survey_category as $category)<option value="{{$category->id}}" @if($item->category_id == $category->id){{"selected"}}@endif>{{$category->nama}}</option>@endforeach                                    
                                        <select> 
                                    </div>                    
                                    <div class="form-group">                        
                                        <input required type="number" class="form-control" name="no_question" placeholder="Number Question ..." value="{{ $item->no_question }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input required type="text" class="form-control" name="keyword" placeholder="Keyword ..." value="{{ $item->keyword }}">
                                    </div>
                                    <div class="form-group">                        
                                        <textarea required type="text" class="form-control" name="text_question" placeholder="Question ...">{{ $item->text_question }}</textarea>
                                    </div>                    
                                    <div class="form-group">                        
                                        <textarea required type="text" class="form-control" name="option_1" placeholder="Opsi 1 ...">{{ $item->option_1 }}</textarea>
                                    </div>
                                    <div class="form-group">                        
                                        <textarea required type="text" class="form-control" name="option_2" placeholder="Opsi 2 ...">{{ $item->option_2 }}</textarea>
                                    </div>                                        
                                    <div class="form-group">                        
                                        <textarea required type="text" class="form-control" name="option_3" placeholder="Opsi 3 ...">{{ $item->option_3 }}</textarea>
                                    </div>                    
                                    <div class="form-group">                        
                                        <textarea required type="text" class="form-control" name="option_4" placeholder="Opsi 4 ...">{{ $item->option_4 }}</textarea>
                                    </div>                    
                                    <div class="form-group">                        
                                        <textarea required type="text" class="form-control" name="option_5" placeholder="Opsi 5 ...">{{ $item->option_5 }}</textarea>
                                    </div>                                        
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info">Submit</button>
                            </form>
                            </div>
                        </div>
                    </div>
                  <td><button class="btn btn-danger" data-toggle="modal" data-target="#deletequestionModal{{ $item->id }}">Delete</button></td>
                  <!-- Modal Delete Data -->
                  <div class="modal fade" id="deletequestionModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deletedataModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="deletequestionModalLabel{{ $item->id }}">Delete Survey Question no {{ $item->no_question }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form action="/super-admin/question-group/delete" method="post">
                            <input type="hidden" name="institution_id" value="{{ $institution_id }}">
                            <input type="hidden" name="question_id" value="{{ $item->id }}">
                            @csrf
                            <div class="modal-body">                    
                                <div>Yakin akan menghapus survey question no {{ $item->no_question }}?</div>                                
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </form>
                        </div>
                    </div>
                </div>
                </tr>
                @endforeach
              </tbody>            
            </table>        
    </div>
</div>  
@endif

@endsection
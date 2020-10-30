@extends('layouts.admindashboard')

@section('header')
Data Survey Question
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <button class="btn btn-info mb-3" data-toggle="modal" data-target="#createdataModal">Create Data</button>

        <!-- Modal Create Data -->
        <div class="modal fade" id="createdataModal" tabindex="-1" role="dialog" aria-labelledby="createdataModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Survey Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="/admin/question/create" method="post">
                    @csrf
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
                            <input required type="text" class="form-control" name="category" placeholder="Category ..." required>
                        </div>                    
                        <div class="form-group">                        
                            <input required type="number" class="form-control" name="no_question" placeholder="Number Question ...">
                        </div>                    
                        <div class="form-group">                        
                            <input required type="text" class="form-control" name="keyword" placeholder="Keyword ...">
                        </div>
                        <div class="form-group">                        
                            <input required type="text" class="form-control" name="text_question" placeholder="Question ...">
                        </div>                    
                        <div class="form-group">                        
                            <input required type="text" class="form-control" name="option_1" placeholder="Opsi 1 ...">
                        </div>
                        <div class="form-group">                        
                            <input required type="text" class="form-control" name="option_2" placeholder="Opsi 2 ...">
                        </div>                                        
                        <div class="form-group">                        
                            <input required type="text" class="form-control" name="option_3" placeholder="Opsi 3 ...">
                        </div>                    
                        <div class="form-group">                        
                            <input required type="text" class="form-control" name="option_4" placeholder="Opsi 4 ...">
                        </div>                    
                        <div class="form-group">                        
                            <input required type="text" class="form-control" name="option_5" placeholder="Opsi 5 ...">
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
                            <form action="/admin/question/update" method="post">
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
                                        <input required type="text" class="form-control" name="category" placeholder="Category ..." value="{{ $item->category }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input required type="number" class="form-control" name="no_question" placeholder="Number Question ..." value="{{ $item->category }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input required type="text" class="form-control" name="keyword" placeholder="Keyword ..." value="{{ $item->keyword }}">
                                    </div>
                                    <div class="form-group">                        
                                        <input required type="text" class="form-control" name="text_question" placeholder="Question ..." value="{{ $item->text_question }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input required type="text" class="form-control" name="option_1" placeholder="Opsi 1 ..." value="{{ $item->option_1 }}">
                                    </div>
                                    <div class="form-group">                        
                                        <input required type="text" class="form-control" name="option_2" placeholder="Opsi 2 ..." value="{{ $item->option_2 }}">
                                    </div>                                        
                                    <div class="form-group">                        
                                        <input required type="text" class="form-control" name="option_3" placeholder="Opsi 3 ..." value="{{ $item->option_3 }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input required type="text" class="form-control" name="option_4" placeholder="Opsi 4 ..." value="{{ $item->option_4 }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input required type="text" class="form-control" name="option_5" placeholder="Opsi 5 ..." value="{{ $item->option_5 }}">
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
                        <h5 class="modal-title" id="deletequestionModalLabel{{ $item->id }}">Delete Survey Question no {{ $item->id }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form action="/admin/question/delete" method="post">
                            <input type="hidden" name="question_id" value="{{ $item->id }}">
                            @csrf
                            <div class="modal-body">                    
                                <div>Yakin akan menghapus survey question no {{ $item->id }}?</div>                                
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

@endsection
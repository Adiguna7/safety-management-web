@extends('layouts.superadmindashboard')

@section('header')
Data Category Question
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Category Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="/super-admin/category-question/create" method="post">
                    @csrf
                    <div class="modal-body">                                            
                        <div class="form-group">                        
                            <input required type="text" class="form-control" name="nama" placeholder="Nama Category ..." required>
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
                  <th>Nama</th>
                  <th>Created At</th>
                  <th>Updated At</th>                  
                </tr>
              </thead>              
              <tbody>
                @foreach ($survey_category as $item)                                
                <tr>
                  <td>{{ $item->id }}</td>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->created_at }}</td>
                  <td>{{ $item->updated_at }}</td>                                 
                  <td><button class="btn btn-info" data-toggle="modal" data-target="#updatequestionModal{{ $item->id }}">Update</button></td>
                    <!-- Modal Update Data -->
                    <div class="modal fade" id="updatequestionModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updatequestionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="updatedataModalLabel{{ $item->id }}">Update Category Question {{ $item->nama }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="/super-admin/category-question/update" method="post">
                                <input type="hidden" name="category_id" value="{{ $item->id }}">
                                @csrf
                                <div class="modal-body">                                                        
                                    <div class="form-group">                        
                                        <input required type="text" class="form-control" name="nama" placeholder="Nama Category ..." value="{{ $item->nama }}">
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
                        <h5 class="modal-title" id="deletequestionModalLabel{{ $item->id }}">Delete Survey Question {{ $item->nama }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form action="/super-admin/category-question/delete" method="post">
                            <input type="hidden" name="category_id" value="{{ $item->id }}">
                            @csrf
                            <div class="modal-body">                    
                                <div>Yakin akan menghapus category question {{ $item->nama }}?</div>                                
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
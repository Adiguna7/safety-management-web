@extends('layouts.superadmindashboard')

@section('header')
Data Alternatif Solusi
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Institusi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="/super-admin/institution/create" method="post">
                    @csrf
                    <div class="modal-body">                                            
                        <div class="form-group">                        
                            <input type="text" class="form-control" name="institution_name" placeholder="Institution Name ..." required>
                        </div>                    
                        <div class="form-group">                        
                            <input type="text" class="form-control" name="institution_code" placeholder="Institution Code ..." required>
                        </div>                    
                        <div class="form-group">                        
                            <input type="number" class="form-control" name="max_response" placeholder="Max Response ..." required>
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
                  <th>Institution Name</th>
                  <th>Institution Code</th>
                  <th>User Response</th>
                  <th>Max Response</th>                  
                  <th>Update</th>
                  <th>Delete</th>
                </tr>
              </thead>              
              <tbody>
                @foreach ($institutions as $item)                                
                <tr>
                  <td>{{ $item->id }}</td>
                  <td>{{ $item->institution_name }}</td>
                  <td>{{ $item->institution_code }}</td>
                  <td>{{ $item->response }}</td>
                  <td>{{ $item->max_response }}</td>                  
                  <td><button class="btn btn-info" data-toggle="modal" data-target="#updateinstitutionModal{{ $item->id }}">Update</button></td>
                    <!-- Modal Update Data -->
                    <div class="modal fade" id="updateinstitutionModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updateinstitutionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="updateinstitutionModalLabel{{ $item->id }}">Update Institusi ID {{ $item->id }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="/super-admin/institution/update" method="post">
                                <input type="hidden" name="institution_id" value="{{ $item->id }}">
                                @csrf
                                <div class="modal-body">                    
                                    <div class="form-group">                        
                                        <input type="text" class="form-control" name="institution_name" placeholder="Institution Name ..." required value="{{ $item->institution_name }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input type="text" class="form-control" name="institution_code" placeholder="Institution Code ..." required value="{{ $item->institution_code }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input type="number" class="form-control" name="max_response" placeholder="Max Response ..." required value="{{ $item->max_response }}">
                                    </div>                                       
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info">Submit</button>
                            </form>
                            </div>
                        </div>
                    </div>
                  <td><button class="btn btn-danger" data-toggle="modal" data-target="#deleteinstitutionModal{{ $item->id }}">Delete</button></td>
                  <!-- Modal Update Data -->
                  <div class="modal fade" id="deleteinstitutionModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteinstitutionModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="deletedatainstitutionLabel{{ $item->id }}">Delete Institution ID {{ $item->id }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form action="/super-admin/institution/delete" method="post">
                            <input type="hidden" name="institution_id" value="{{ $item->id }}">
                            @csrf
                            <div class="modal-body">                    
                                <div>Yakin akan menghapus institution id {{ $item->id }}?</div>                                
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
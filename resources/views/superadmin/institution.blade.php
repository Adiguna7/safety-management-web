@extends('layouts.superadmindashboard')

@section('header')
Data Institusi / Perusahaan
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
                        <div class="form-group">                                                    
                            <select class="form-control" required name="category" onchange="checkExpert(this.value)">
                                <option disabled selected>Category ...</option>
                                <option value="institution">Institusi</option>
                                <option value="company">Perusahaan</option>
                                <option value="umum">Umum</option>
                                <option value="expert">Expert</option>
                            </select>
                        </div>
                        <div id="ParentId" class="form-group" style="display: none">                                                    
                            <select class="form-control" name="parent_id">
                                <option disabled selected>Expert For ...</option>
                                @foreach ($institutions as $item)
                                    @if($item->category == "expert" || $item->category == "umum")         
                                        @continue
                                    @endif                                           
                                    <option value="{{$item->id}}">{{$item->institution_name}}</option>                                    
                                @endforeach
                            </select>                           
                            {{-- <input type="text" class="form-control" name="parent_id" placeholder="Expert From ..." required>                             --}}
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
                  <th>Category</th>
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
                    <td>{{ strtoupper($item->category) }}
                        @if(!empty($item->parent_id))
                        (
                        @foreach($institutions as $item2)
                            @if($item->parent_id == $item2->id)
                                {{$item2->institution_name}}
                            @endif
                        @endforeach
                        )
                        @endif
                    </td>
                    <td>{{ $item->response }}</td>
                    <td>{{ $item->max_response }}</td>                  
                    <td><button class="btn btn-info" data-toggle="modal" data-target="#updateinstitutionModal{{ $item->id }}" onclick="checkExpert(document.getElementById('Category{{$item->id}}').value, 'ParentId{{$item->id}}')">Update</button></td>
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
                                    <div class="form-group">                                                    
                                        <select id="Category{{$item->id}}" class="form-control" required name="category" onchange="checkExpert(this.value, 'ParentId{{$item->id}}')">
                                            <option disabled selected>Category ...</option>
                                            <option value="institution" @if($item->category == "institution") selected @endif>Institusi</option>
                                            <option value="company" @if($item->category == "company") selected @endif>Perusahaan</option>
                                            <option value="umum" @if($item->category == "umum") selected @endif>Umum</option>
                                            <option value="expert" @if($item->category == "expert") selected @endif>Expert</option>
                                        </select>
                                    </div>                                    
                                    <div id="ParentId{{$item->id}}" class="form-group" style="display: none">                                                    
                                        <select class="form-control" name="parent_id">
                                            <option disabled selected>Expert For ...</option>
                                            @foreach ($institutions as $item2)
                                                @if($item2->category == "expert" || $item2->category == "umum")         
                                                    @continue
                                                @endif                                           
                                                <option value="{{$item2->id}}" @if($item->parent_id == $item2->id) selected @endif>{{$item2->institution_name . " - " . $item2->id}}</option>                                    
                                            @endforeach
                                        </select>                           
                                        {{-- <input type="text" class="form-control" name="parent_id" placeholder="Expert From ..." required>                             --}}
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

<script src="{{ asset('js/institution.js') }}"></script>
@endsection
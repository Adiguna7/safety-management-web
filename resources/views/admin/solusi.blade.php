@extends('layouts.admindashboard')

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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Alternatif Solusi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="/admin/solusi/create" method="post">
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
                            <input type="text" class="form-control" name="solution" placeholder="Solution ..." required>
                        </div>                    
                        <div class="form-group">                        
                            <input type="text" class="form-control" name="article" placeholder="Article ...">
                        </div>                    
                        <div class="form-group">                        
                            <input type="text" class="form-control" name="tahun" placeholder="Tahun ...">
                        </div>
                        <div class="form-group">                        
                            <input type="text" class="form-control" name="author" placeholder="Author ...">
                        </div>                    
                        <div class="form-group">                        
                            <input type="text" class="form-control" name="link_doi" placeholder="Link DOI ...">
                        </div>                    
                        <div class="form-group">                        
                            <input type="text" class="form-control" name="company_background" placeholder="Company Background ...">
                        </div>                    
                        <div class="form-group">                        
                            <input type="text" class="form-control" name="keterangan" placeholder="Keterangan ...">
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
                  <th>Solution</th>
                  <th>Article</th>
                  <th>Tahun</th>
                  <th>Author</th>
                  <th>Link Doi</th>
                  <th>Company Background</th>
                  <th>Keterangan</th>
                  <th>Update</th>
                  <th>Delete</th>
                </tr>
              </thead>              
              <tbody>
                @foreach ($solutions as $item)                                
                <tr>
                  <td>{{ $item->id }}</td>
                  <td>{{ $item->dimensi }}</td>
                  <td>{{ $item->solution }}</td>
                  <td>{{ $item->article }}</td>
                  <td>{{ $item->tahun }}</td>
                  <td>{{ $item->author }}</td>
                  <td>{{ $item->link_doi }}</td>
                  <td>{{ $item->company_background }}</td>
                  <td>{{ $item->keterangan }}</td>
                  <td><button class="btn btn-info" data-toggle="modal" data-target="#updatedataModal{{ $item->id }}">Update</button></td>
                    <!-- Modal Update Data -->
                    <div class="modal fade" id="updatedataModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updatedataModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="updatedataModalLabel{{ $item->id }}">Update Alternatif Solusi ID {{ $item->id }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="/admin/solusi/update" method="post">
                                <input type="hidden" name="solutions_id" value="{{ $item->id }}">
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
                                        <input type="text" class="form-control" name="solution" placeholder="Solution ..." required value="{{ $item->solution }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input type="text" class="form-control" name="article" placeholder="Article ..." value="{{ $item->article }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input type="text" class="form-control" name="tahun" placeholder="Tahun ..." value="{{ $item->tahun }}">
                                    </div>
                                    <div class="form-group">                        
                                        <input type="text" class="form-control" name="author" placeholder="Author ..." value="{{ $item->author }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input type="text" class="form-control" name="link_doi" placeholder="Link DOI ..." value="{{ $item->link_doi }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input type="text" class="form-control" name="company_background" placeholder="Company Background ..." value="{{ $item->company_background }}">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input type="text" class="form-control" name="keterangan" placeholder="Keterangan ..." value="{{ $item->keterangan }}">
                                    </div>                                        
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info">Submit</button>
                            </form>
                            </div>
                        </div>
                    </div>
                  <td><button class="btn btn-danger" data-toggle="modal" data-target="#deletedataModal{{ $item->id }}">Delete</button></td>
                  <!-- Modal Update Data -->
                  <div class="modal fade" id="deletedataModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deletedataModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="deletedataModalLabel{{ $item->id }}">Delete Alternatif Solusi ID {{ $item->id }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form action="/admin/solusi/delete" method="post">
                            <input type="hidden" name="solutions_id" value="{{ $item->id }}">
                            @csrf
                            <div class="modal-body">                    
                                <div>Yakin akan menghapus alternatif solusi id {{ $item->id }}?</div>                                
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
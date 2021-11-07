@extends('layouts.superadmindashboard')

@section('header')
Data Pembobotan Nilai Institusi / Perusahaan
@endsection

@section('content')
<div class="row" style="min-height: 100vh">    
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Institusi Name</th>
                  <th>Nilai Expert</th>
                  <th>Nilai User</th>                                                     
                  <th>Update</th>                        
                </tr>
              </thead>              
              <tbody>
                @foreach ($pembobotan as $item)                                
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->institution }}</td>
                    <td>{{ $item->nilai_expert }}</td>
                    <td>{{ $item->nilai_users }}</td>                                        
                    <td><button class="btn btn-info" data-toggle="modal" data-target="#updatepembobotanModal{{ $item->id }}">Update</button></td>
                    <!-- Modal Update Data -->
                    <div class="modal fade" id="updatepembobotanModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updatepembobotanModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="updatepembobotanModalLabel{{ $item->id }}">Update Pembobotan {{ $item->institution }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="/super-admin/pembobotan/update" method="post">
                                <input type="hidden" name="pembobotan_id" value="{{ $item->id }}">
                                <input type="hidden" name="institution_id" value="{{ $item->insitution_id }}">
                                @csrf
                                <div class="modal-body">                    
                                    <div class="form-group">                        
                                        <input type="number" class="form-control" name="nilai_expert" placeholder="Nilai Expert (%) ..." required value="{{ $item->nilai_expert }}" oninput="if(this.value > 100){this.value = 100} else if(this.value == null || this.value == ''){this.value = null} else if(this.value < 0){this.value = 0} document.getElementById('NilaiUsers{{$item->id}}').value = 100 - this.value">
                                    </div>                    
                                    <div class="form-group">                        
                                        <input id="NilaiUsers{{$item->id}}" disabled type="number" class="form-control" name="" placeholder="Nilai Users (%) ..." required value="{{ $item->nilai_users }}">
                                    </div>                                                                                                                                                                      
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info">Submit</button>                            
                                </div>
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
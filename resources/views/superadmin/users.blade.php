@extends('layouts.superadmindashboard')

@section('header')
Data Users
@endsection

@section('content')
<div class="row" style="min-height: 100vh">    
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Admin</th>  
                  <th>Institution</th>                                  
                  <th>Role</th>
                </tr>
              </thead>              
              <tbody>
                @foreach ($users as $item)      
                @if(Auth::user()->role != "super_admin" && Auth::user()->institution_id != $item->institution_id)
                  @continue
                @endif                          
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>                    
                    <td>{{ $item->is_admin }}</td>
                    <td>
                      <form action="/super-admin/users/updateinstitution" method="post">
                        @csrf
                        <input type="hidden" name="userid" value="{{$item->id}}">
                        @if(Auth::user()->role == "super_admin")                                                    
                          <select name="institution_id" class="form-control" required name="role" onchange="this.form.submit()">
                            @foreach($institution as $item2)                                
                              <option value="{{$item2->id}}" @if($item->institution_id == $item2->id) selected @endif>{{$item2->institution_name}}</option>
                            @endforeach   
                          </select>                   
                        @else
                          {{$item->institution}}
                        @endif
                      </form>
                    </td>                    
                    <td>                        
                        <form action="/super-admin/users/updateadmin" method="post">
                            @csrf                            
                            <input type="hidden" name="userid" value="{{ $item->id }}">
                            @if($item->id != Auth::user()->id)
                            <div class="form-group">                                                
                              <select class="form-control" required name="role" onchange="this.form.submit()">
                                  <option disabled>Role ...</option>
                                  @if(Auth::user()->role == "super_admin")                                                                    
                                  <option value="super_admin" @if($item->role == "super_admin") selected @endif>Super Admin</option>
                                  <option value="admin" @if($item->role == "admin") selected @endif>Admin Perusahaan</option>
                                  <option value="user_perusahaan" @if($item->role == "user_perusahaan") selected @endif>User Perusahaan</option>
                                  <option value="user" @if($item->role == "user") selected @endif>User Umum</option>
                                  <option value="deleted" @if($item->role == "deleted") selected @endif>Delete Account</option>
                                  @elseif(Auth::user()->role == "admin")
                                    @if($item->role == "super_admin")
                                      <option disabled selected>Super Admin</option>
                                    @else                                      
                                      <option value="admin" @if($item->role == "admin") selected @endif>Admin Perusahaan</option>
                                      <option value="user_perusahaan" @if($item->role == "user_perusahaan") selected @endif>User Perusahaan</option>
                                      <option value="user" @if($item->role == "user") selected @endif>User Umum</option>
                                      <option value="deleted" @if($item->role == "deleted") selected @endif>Delete Account</option>
                                      {{-- <option value="user" @if($item->role == "user") selected @endif>User Umum</option> --}}
                                    @endif                                  
                                  @endif                                  
                              </select>
                            </div>
                            @else
                            Own Account
                            @endif                            
                            {{-- <button type="submit" class="btn btn-info">change</button> --}}
                        </form>                                                
                    </td>                                                                          
                </tr>
                @endforeach
              </tbody>            
            </table>        
    </div>
</div>  

@endsection
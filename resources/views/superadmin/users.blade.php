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
                  <th>Action</th>
                </tr>
              </thead>              
              <tbody>
                @foreach ($users as $item)                                
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->is_admin }}</td>
                    <td class="text-center">
                        @if($item->is_admin == 1)
                        <form action="/super-admin/users/updateadmin" method="post">
                            @csrf
                            <input type="hidden" name="is_admin" value="{{ $item->is_admin }}">
                            <input type="hidden" name="userid" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-info">to user</button>
                        </form>                        
                        @else
                        <form action="/super-admin/users/updateadmin" method="post">
                            @csrf
                            <input type="hidden" name="is_admin" value="{{ $item->is_admin }}">
                            <input type="hidden" name="userid" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-danger">to admin</button>
                        </form>        
                        @endif
                    </td>                                                                          
                </tr>
                @endforeach
              </tbody>            
            </table>        
    </div>
</div>  

@endsection
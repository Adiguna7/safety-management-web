@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <br/>
                    <br/>
                    @if(Auth::user()->role == "super_admin")
                    <button class="text-white btn btn-info" onclick="window.location.href='super-admin/dashboard'">Go to Dashboard</button>
                    @elseif(Auth::user()->role == "admin")
                    <button class="text-white btn btn-info" onclick="window.location.href='super-admin/dashboard'">Go to Dashboard</button>
                    @elseif(Auth::user()->role == "user_perusahaan")
                    <button class="text-white btn btn-info" onclick="window.location.href='user/dashboard'">Go to Dashboard</button>
                    @elseif(Auth::user()->role == "user")
                    <button class="text-white btn btn-info" onclick="window.location.href='user/dashboard'">Go to Dashboard</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

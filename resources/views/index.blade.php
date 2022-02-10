@extends('layout.master')
@section('content')
    <!-- Index -->
    @if(Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            Welcome, <strong>{{ $LoggedUserInfo['first_name'].' '.$LoggedUserInfo['last_name'] }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container-fluid row">
        @if($LoggedUserInfo['role']=='Admin')
        <div class="card border-left-primary mx-2" style="width: 18rem;">
            <div class="card-body">
            <h5 class="card-title">Total users</h5>
            <p class="card-text"><i class="fas fa-users"> </i> {{ $numberOfUsers }}</p>
            </div>
        </div>
        <br>
        @endif

        <div class="card" style="width: 18rem;">
            <div class="card-body">
            <h5 class="card-title">{{$LoggedUserInfo['role'] == 'Admin' ? 'Total' : 'Own'}} files</h5>
            <p class="card-text"><i class="fas fa-file"> </i> @if($LoggedUserInfo['role'] == 'Admin') {{ $numberOfFiles }} @else {{ $filecount }} @endif</p>
            </div>
        </div>
    </div>
@endsection
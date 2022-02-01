@extends('layout.master')
@section('content')
    <!-- Index -->
    <div class="alert alert-success">
        Welcome, {{ $LoggedUserInfo['first_name'] }}
    </div>
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
            <h5 class="card-title">Total files</h5>
            <p class="card-text"><i class="fas fa-file"> </i> @if($LoggedUserInfo['role'] == 'Admin') {{ $numberOfFiles }} @else {{ $filecount }} @endif</p>
            </div>
        </div>
    </div>
@endsection
@extends('layout.master')
@section('content')

<div class="container-fluid col-md-6">
    <h4>
        Change Password
    </h4>
    <form action="{{ route('me.updatepw') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="oldPassword" class="col-form-label">Old Password:</label>
            <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
            <span class="text-danger">@error('oldPassword'){{ $message }} @enderror</span>
        </div>
        <div class="form-group">
            <label for="newPassword" class="col-form-label">New Password:</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
        </div>
        <div class="form-group">
            <label for="confirmPassword" class="col-form-label">Confirm Password:</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            <span class="text-danger">@error('confirmPassword'){{ $message }} @enderror</span>
        </div>
        <div class="d-grid gap-2 mt-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
            <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary"><i class="fas fa-times"></i>
                Cancel</a>
        </div>
    </form>
</div>


@endsection
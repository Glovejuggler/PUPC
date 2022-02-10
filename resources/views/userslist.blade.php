@extends('layout.master')
@section('content')

@if ($LoggedUserInfo['role'] == 'Admin')
    

<div class="container-fluid">
    <button
        type="button"
        class="btn btn-success btn-floating btn-lg"
        id="btn-add"
        data-toggle="modal"
        data-target="#addUserModal">
        <i class="fas fa-plus"></i>
    </button>

    {{-- <div class="d-flex">
        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addUserModal">
            <i class="fas fa-plus"></i>
            Add new user
        </button>
    </div> --}}
    
    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalTitle">Add new user</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.create') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="first_name" class="col-form-label">First Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-form-label">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="middle_name" class="col-form-label">Middle Name:</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name">
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Role:</label>
                            <select class="form-select" aria-label="Default select example" id="role" name="role">
                                <option value="" selected disabled hidden>Select role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->role_name }}">{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <br>

    <table id="myTable" class="table table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->first_name}}</td>
                    <td>{{$user->last_name}}</td>
                    <td>{{$user->address}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role}}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <div>
                                <a href="{{route('user.show', $user)}}">
                                    <button id="viewUser" class="btn btn-primary btn-sm view">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </a>
                            </div>
                            <button type="submit" class="btn btn-danger btn-sm mx-2"
                                data-toggle="modal"
                                data-target="#removeUserModal"
                                data-url="{{route('user.delete', $user)}}"
                                id="btn-delete-user">
                                <i class="fas fa-trash"></i>
                            </button>

                            {{-- Delete Confirm Modal --}}
                            <div class="modal fade" id="removeUserModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="removeUserLabel">Confirmation</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('user.delete', $user)}}" method="POST" id="removeUserModalForm">
                                            @method('DELETE')
                                            @csrf
                                            <div class="modal-body">
                                                Are you sure you want to delete this user?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    
@else
    <h4>
        You cannot access this page
    </h4>
@endif

@endsection

@section('scripts')
<script>
    $(document).on('click', '#btn-delete-user', function(e) {
        e.preventDefault();

        const url = $(this).data('url');

        $('#removeUserModalForm').attr('action', url);
    });
</script>
@endsection
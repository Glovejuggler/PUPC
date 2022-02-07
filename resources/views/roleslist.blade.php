@extends('layout.master')
@section('content')

@if ($LoggedUserInfo['role'] == 'Admin')
    

<div class="container-fluid">
    <button
        type="button"
        class="btn btn-success btn-floating btn-lg"
        id="btn-add"
        data-toggle="modal"
        data-target="#addRoleModal">
        <i class="fas fa-plus"></i>
    </button>

    
    <!-- Add Role Modal -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoleModalTitle">Add new role</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <form action="{{ route('role.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="role_name" class="col-form-label">Role:</label>
                            <input type="text" class="form-control" id="role_name" name="role_name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <br>

    <table id="myTable" class="table table-striped">

        <thead>
            <tr>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{$role->role_name}}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-danger btn-sm mx-2"
                                data-toggle="modal"
                                data-target="#removeRoleModal"
                                data-url="{{ route('role.destroy', $role) }}"
                                id="btn-delete-role">
                                <i class="fas fa-trash"></i>
                            </button>

                            {{-- Delete Confirm Modal --}}
                            <div class="modal fade" id="removeRoleModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="removeRoleLabel">Confirmation</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('role.destroy', $role) }}" method="POST" id="removeRoleModalForm">
                                            @method('DELETE')
                                            @csrf
                                            <div class="modal-body">
                                                Are you sure you want to delete this role?
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
    $(document).on('click', '#btn-delete-role', function(e) {
        e.preventDefault();

        const url = $(this).data('url');

        $('#removeRoleModalForm').attr('action', url);
    });
</script>
@endsection
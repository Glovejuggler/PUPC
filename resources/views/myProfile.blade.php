@extends('layout.master')
@section('content')

<div class="container-fluid col-md-6">
    <div class="row">
        <h4 class="col-auto me-auto">
            My Information
        </h4>
        <a href="{{ route('me.edit') }}" class="col-auto">
            <h4><i class="fas fa-edit" style="color: black"></i></h4>
        </a>
    </div>
        <div class="row">
            <div class="col form-group">
                <label for="first_name" class="col-form-label">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $LoggedUserInfo->first_name }}" disabled>
            </div>
            <div class="col form-group">
                <label for="last_name" class="col-form-label">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $LoggedUserInfo->last_name }}" disabled>
            </div>
        </div>
        <div class="form-group">
            <label for="middle_name" class="col-form-label">Middle Name:</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ $LoggedUserInfo->middle_name }}" disabled>
        </div>
        <div class="form-group">
            <label for="address" class="col-form-label">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $LoggedUserInfo->address }}" disabled>
        </div>
        <div class="form-group">
            <label for="role" class="col-form-label">Role:</label>
            <input type="text" class="form-control" id="role" name="role" value="{{ $LoggedUserInfo->role }}" disabled>
        </div>
        <div class="form-group">
            <label for="email" class="col-form-label">Email:</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ $LoggedUserInfo->email }}" disabled>
        </div><br>
        <h4>Files</h4>
        <div class="row mx-6">
            <table id="myTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>File name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td>{{ $file->filename }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    @if (in_array(pathinfo(storage_path($file->filepath), PATHINFO_EXTENSION), $viewable))
                                        <a href="{{ route('viewFile', $file) }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                    @endif
                                    <a href="{{ $file->filepath }}" download class="btn btn-sm btn-success mx-1"><i class="fas fa-download"></i></a>
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        data-toggle="modal"
                                        data-target="#removeFileModal"
                                        data-url="{{route('file.delete', $file)}}"
                                        id="btn-delete-file">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    {{-- Delete Confirm Modal --}}
                                    <div class="modal fade" id="removeFileModal" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="removeFileLabel">Confirmation</h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{route('file.delete', $file)}}" method="POST" id="removeFileModalForm">
                                                    @method('DELETE')
                                                    @csrf
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this file?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash icon-left"></i> Delete
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
    </div>

    
</div>

@endsection

@section('scripts')
<script>
    $(document).on('click', '#btn-delete-file', function(e) {
        e.preventDefault();

        const url = $(this).data('url');

        $('#removeFileModalForm').attr('action', url);
    });
</script>
@endsection
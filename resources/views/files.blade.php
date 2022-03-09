@extends('layout.master')
@section('content')

{{-- Upload Form --}}
<div class="container">
    <form action="{{ route('uploadfile') }}" method="post" enctype="multipart/form-data">
        <h3 class="text-center mb-3">Upload Files</h3>
        @csrf
        @if(Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>File has been uploaded successfully!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        {{-- Ayaw gumana ng multiple file uploads --}}
        <div class="row mb-2">
            <label class="col-form-label" for="chooseFile">Select file/s to upload</label>
            <input type="file" name="file[]" class="form-control" id="chooseFile" multiple>

            <button type="submit" name="submit" class="btn btn-primary btn-block mt-3">
                Upload Files
            </button>
        </div>
    </form>
</div>
<br>

{{-- Files' list --}}
<div class="container">
    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#gridview" type="button"
                role="tab" aria-controls="home" aria-selected="true">Grid view</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#listview" type="button"
                role="tab" aria-controls="profile" aria-selected="false">List view</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="gridview" role="tabpanel" aria-labelledby="grid-tab">
            <div class="row">
                @foreach($files as $file)
                {{-- If the logged user is admin, show all files instead --}}
                <div class="card mx-1 mt-2" style="width: 250px">
                    <div class="card-body">
                        <div class="col">
                            <h6 class="text-truncate">{{$file->filename}}</h6>
                        </div>
                        <h6 class="card-subtitle mb-2 {{ $file->user == NULL ? 'text-danger' : 'text-muted' }}">{{
                            $file->user == NULL ? 'Deleted User' : $file->user->first_name.' '.$file->user->last_name }}
                        </h6>
                        @if (in_array(pathinfo(storage_path($file->filepath), PATHINFO_EXTENSION), $viewable))
                        <a href="{{ route('viewFile', $file) }}" target="_blank" class="btn btn-sm btn-primary"><i
                                class="fas fa-eye"></i></a>
                        @endif
                        <a href="{{ $file->filepath }}" download class="btn btn-sm btn-success"><i
                                class="fas fa-download"></i></a>
                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#removeFileModal" data-url="{{route('file.delete', $file)}}"
                            id="btn-delete-file">
                            <i class="fas fa-trash"></i>
                        </button>

                        {{-- Delete Confirm Modal --}}
                        <div class="modal fade" id="removeFileModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="removeFileLabel">Confirmation</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('file.delete', $file)}}" method="POST"
                                        id="removeFileModalForm">
                                        @method('DELETE')
                                        @csrf
                                        <div class="modal-body">
                                            Are you sure you want to delete this file?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash icon-left"></i> Delete
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="listview" role="tabpanel" aria-labelledby="list-tab">
            <table id="myTable" class="table table-striped">

                <thead>
                    <tr>
                        <th>File name</th>
                        <th>Uploader</th>
                        <th>Date uploaded</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($files as $file)

                    <tr>
                        <td>{{$file->filename}}</td>
                        <td class="{{ $file->user == NULL ? 'text-danger' : '' }}">{{ $file->user == NULL ? 'Deleted
                            User' : $file->user->first_name.' '.$file->user->last_name }}</td>
                        <td>{{ $file->created_at->format('M d, Y \a\t H:i') }} <span class="text-muted">{{
                                $file->created_at->diffForHumans() }}</span> </td>
                        <td>
                            <div class="d-flex justify-content-end">
                                @if (in_array(pathinfo(storage_path($file->filepath), PATHINFO_EXTENSION), $viewable))
                                <a href="{{ route('viewFile', $file) }}" target="_blank"
                                    class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                @endif
                                <a href="{{ $file->filepath }}" download class="btn btn-sm btn-success mx-1"><i
                                        class="fas fa-download"></i></a>
                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#removeFileModalT" data-url="{{route('file.delete', $file)}}"
                                    id="btn-delete-file">
                                    <i class="fas fa-trash"></i>
                                </button>

                                {{-- Delete Confirm Modal --}}
                                <div class="modal fade" id="removeFileModalT" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="removeFileLabel">Confirmation</h5>
                                                <button type="button" class="btn-close" data-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{route('file.delete', $file)}}" method="POST"
                                                id="removeFileModalForm">
                                                @method('DELETE')
                                                @csrf
                                                <div class="modal-body">
                                                    Are you sure you want to delete this file?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-dismiss="modal">Close</button>
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
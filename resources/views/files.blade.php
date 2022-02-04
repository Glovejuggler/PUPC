@extends('layout.master')
@section('content')
    
<div class="container">
    <form action="{{ route('uploadfile') }}" method="post" enctype="multipart/form-data">
        <h3 class="text-center mb-3">Upload Files</h3>
        @csrf
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <strong>{{ $message }}</strong>
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
            <input type="file" name="file" class="form-control" id="chooseFile">
            
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
          <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#gridview" type="button" role="tab" aria-controls="home" aria-selected="true">Grid view</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#listview" type="button" role="tab" aria-controls="profile" aria-selected="false">List view</button>
        </li>   
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="gridview" role="tabpanel" aria-labelledby="grid-tab">
            <div class="row">
                @foreach($files as $file)

                    {{-- If the logged user is not admin, show the files of their respective roles only --}}
                    @if($LoggedUserInfo['role'] != 'Admin')
                        @if($file->user != NULL )
                            @if($file->user->role == $LoggedUserInfo['role'])
                                <div class="card mx-1 mt-2" style="width: 250px">
                                    <div class="card-body">
                                        <div style="dispay: inline; width: 180px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis">
                                            <h6>{{$file->filename}}</h6>
                                        </div>
                                        <h6 class="card-subtitle mb-2 text-muted">{{ $file->user == NULL ? 'Deleted User' : $file->user->first_name.' '.$file->user->last_name }}</h6>
                                        <a href="{{ route('viewFile', $file) }}" target="_blank" class="btn btn-sm btn-primary {{ pathinfo(storage_path($file->filepath), PATHINFO_EXTENSION) == 'pptx' || pathinfo(storage_path($file->filepath), PATHINFO_EXTENSION) == 'docx' ? 'disabled' : '' }}"><i class="fas fa-eye"></i></a>
                                    <a href="{{ $file->filepath }}" download class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @else
                        {{-- If the logged user is admin, show all files instead --}}
                        <div class="card mx-1 mt-2" style="width: 250px">
                            <div class="card-body">
                                <div style="dispay: inline; width: 180px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis">
                                    <h6>{{$file->filename}}</h6>
                                </div>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $file->user == NULL ? 'Deleted User' : $file->user->first_name.' '.$file->user->last_name }}</h6>
                            <a href="{{ route('viewFile', $file) }}" target="_blank" class="btn btn-sm btn-primary {{ pathinfo(storage_path($file->filepath), PATHINFO_EXTENSION) == 'pptx' || pathinfo(storage_path($file->filepath), PATHINFO_EXTENSION) == 'docx' ? 'disabled' : '' }}"><i class="fas fa-eye"></i></a>
                            <a href="{{ $file->filepath }}" download class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>
                            </div>
                        </div> 
                    @endif
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="listview" role="tabpanel" aria-labelledby="list-tab">
            <table id="myTable" class="table table-striped">

                <thead>
                    <tr>
                        <th>File name</th>
                        <th>Uploader</th>
                        <th>Actions</th>
                    </tr>
                </thead>
        
                <tbody>
                    @foreach ($files as $file)
                    @if($LoggedUserInfo['role'] != 'Admin')
                        @if($file->user != NULL )
                            @if($file->user->role == $LoggedUserInfo['role'])
                                <tr>
                                    <td>{{$file->filename}}</td>
                                    <td>{{ $file->user == NULL ? 'Deleted User' : $file->user->first_name.' '.$file->user->last_name }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div>
                                                <a href="#">
                                                    <button id="viewUser" class="btn btn-primary btn-sm view">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </a>
                                            </div>
                                            <form action="#" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-success btn-sm mx-2">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @else
                        <tr>
                            <td>{{$file->filename}}</td>
                            <td>{{ $file->user == NULL ? 'Deleted User' : $file->user->first_name.' '.$file->user->last_name }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <div>
                                        <a href="#">
                                            <button id="viewUser" class="btn btn-primary btn-sm view">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <form action="#" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-success btn-sm mx-2">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</div>
@endsection
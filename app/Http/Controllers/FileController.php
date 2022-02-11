<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MainController;

class FileController extends Controller
{
    public function index(){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $files = File::all();
        $user = User::with('file')->get();
        $viewable = [
            'pdf',
            'jpg',
            'png',
        ];

        return view('files', compact('files', 'user', 'viewable'), $data);
    }

    public function fileUpload(Request $req){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $userid = $data['LoggedUserInfo']->id;

        $req->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf,jpg,jpeg,png,docx,pptx|max:8192'
        ]);

        $fileModel = new File;

        if($req->file()) {
            $fileName = $req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');

            $fileModel->filename = $fileName;
            $fileModel->filepath = '/storage/' . $filePath;
            $fileModel->uploader_id = $userid;

            $fileModel->save();

            return back()
                    ->with('success','File has been uploaded.')
                    ->with('file', $fileName);
        }
    }

    public function view(File $file){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $file = File::with('user')->findorfail($file->id);

        if($data['LoggedUserInfo']->role != 'Admin'){
            if($data['LoggedUserInfo']->role != $file->user->role){
                return redirect()->back();
            }
        }
        
        return view('viewFile', compact('file'), $data);
    }

    public function trash(File $file){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $file->delete();
        unlink(storage_path('../public/storage/uploads/'.$file->filename));

        return Redirect()->route('uploadfile');
    }
}

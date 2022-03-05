<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\MainController;

class FileController extends Controller
{
    public function index(){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        
        $user = User::with('file')->get();
        if($data['LoggedUserInfo']->role != 'Admin'){
            $files = File::wherehas('user', function(Builder $query){
                $user = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
                $query->where('role','=',$user['LoggedUserInfo']->role);
            })->get();
        } else {
            $files = File::all();
        }
        $viewable = [
            'pdf',
            'jpg',
            'png',
            'txt',
        ];

        return view('files', compact('files', 'user', 'viewable'), $data);
    }

    public function fileUpload(Request $req){
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        $userid = $data['LoggedUserInfo']->id;

        $req->validate([
            'file' => 'required',
            'file.*' => 'mimes:csv,txt,xlx,xls,pdf,jpg,jpeg,png,docx,pptx|max:8192'
        ]);

        // $fileModel = new File;
        if($req->hasFile('file')) {
            foreach($req->file('file') as $key => $file){

                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                $insert[$key]['filename'] = $fileName;
                $insert[$key]['filepath'] = '/storage/' . $filePath;
                $insert[$key]['uploader_id'] = $userid;
                $insert[$key]['created_at'] = now();

                // $fileModel->filename = $fileName;
                // $fileModel->filepath = '/storage/' . $filePath;
                // $fileModel->uploader_id = $userid;

                // $fileModel->save();

                // return back()
                //         ->with('success','File has been uploaded.')
                //         ->with('file', $fileName);
            }
        }
        
        File::insert($insert);

        return back()
                        ->with('success','File has been uploaded.')
                        ->with('file', $fileName);
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

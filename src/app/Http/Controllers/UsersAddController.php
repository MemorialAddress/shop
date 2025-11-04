<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\UsersAdd;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UploadRequest;

class UsersAddController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function setProfile()
    {
        $users    = User::all();
        $userId = auth()->id();
        $userAdd = UsersAdd::where('user_id', $userId)->first();
        return view('setProfile', compact('users','userAdd'));
    }

    public function store(ProfileRequest $request)
    {
        if ($request->has('image')) {
            session()->flash('uploaded_file', $request->image);
        }

        // UsersAdd のデータ
        $userAddData = $request->only(['user_id', 'post_code', 'address', 'building','image']);

        // user_id で存在チェックして、あれば更新、なければ作成
        UsersAdd::updateOrCreate(
            ['user_id' => $request->user_id],
            $userAddData
        );

        // User のデータ更新
        $userData = $request->only(['id','name']);
        User::find($request->id)->update($userData);

        session()->forget('uploaded_file');

        return redirect('/');
    }

    public function image(UploadRequest $request)
    {
        $file = $request->file('image');
        $file_name = uniqid() . '.' . $file->getClientOriginalExtension();
        $request->file('image')->storeAs('/public/image/profile',$file_name);

        session()->put('uploaded_file', $file_name);

        return redirect()->back();
    }
}
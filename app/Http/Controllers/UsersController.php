<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        return view('users.index', [
            'user' => $request->user(),
        ]);
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->only('name', 'avatar');


        if ($request->hasFile('avatar'))
        {
            $data['avatar'] = $uploader->uploadOriginal($request->avatar);
        }

        $user = $user->update($data);

        return [
            'user' => $user,
        ];

//        return redirect()->route('users.edit', $user->id)->with('success', '个人资料更新成功！');
    }
}

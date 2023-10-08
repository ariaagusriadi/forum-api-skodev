<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{

    public function index()
    {
        return Forum::with('user:id,username')->get();
    }

    public function store(Request $request)
    {
        $this->validateRequest();
        $user = $this->getAuthUser();

        $user->forums()->create([
            'title' => request('title'),
            'body' => request('body'),
            'slug' => Str::slug(request('title'), '-') . '-' . time(),
            'category' => request('category')
        ]);

        return response()->json(['message' => 'Successfully posted']);
    }

    public function show(string $id)
    {
        return Forum::with('user:id,username', 'comments.user:id,username')->find($id);
    }

    public function update(Request $request, string $id)
    {
        $this->validateRequest();

        $user = $this->getAuthUser();
        $forum = Forum::find($id);

        $this->cekOwnership($user->id, $forum->user_id);

        $forum->update([
            'title' => request('title'),
            'body' => request('body'),
            'category' => request('category')
        ]);

        return response()->json(['message' => 'Successfully updated']);
    }

    public function destroy(string $id)
    {
        $user = $this->getAuthUser();
        $forum = Forum::find($id);

        $this->cekOwnership($user->id, $forum->user_id);

        $forum->delete();

        return response()->json(['message' => 'Successfully delete']);
    }

    private function validateRequest()
    {

        $validator = Validator::make(request()->all(), [
            'title' => 'required|min:5',
            'body' => 'required|min:10',
            'category' => 'required'
        ]);

        if ($validator->fails()) {
            response()->json($validator->messages())->send();
            exit;
        }
    }

    private function getAuthUser()
    {
        try {
            return auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            response()->json(['message' => 'not authenticated, you have to login first'])->send();
            exit;
        }
    }

    private function cekOwnership($authUser, $owner)
    {
        if ($authUser != $owner) {
            response()->json(['message' => 'Not Authorized'], 403)->send();
            exit;
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthUserTrait;
use App\Models\Forum;
use Illuminate\Support\Facades\Validator;

class  ForumCommentController extends Controller
{
    use AuthUserTrait;

    public function store(Request $request, $forum_id)
    {
        $this->validateRequest();
        $user = $this->getAuthUser();

        $user->forumComments()->create([
            'body' => request('body'),
            'forum_id' => $forum_id,
        ]);

        return response()->json(['message' => 'Successfully posted']);
    }

    private function validateRequest()
    {

        $validator = Validator::make(request()->all(), [
            'body' => 'required|min:10'
        ]);

        if ($validator->fails()) {
            response()->json($validator->messages())->send();
            exit;
        }
    }

    public function show(string $id)
    {
       
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}

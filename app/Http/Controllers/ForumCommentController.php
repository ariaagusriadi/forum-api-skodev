<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthUserTrait;
use App\Models\Forum;
use App\Models\ForumComment;
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
            response()->json($validator->messages(),422)->send();
            exit;
        }
    }


    public function update(Request $request, $forum_id, $comment_id)
    {
        $this->validateRequest();

        $forumComment = ForumComment::find($comment_id);

        $this->cekOwnership($forumComment->user_id);

        $forumComment->update([
            'body' => request('body')
        ]);

        return response()->json(['message' => 'Successfully update Comment']);
    }

    public function destroy($forum_id, $comment_id)
    {
        $forumComment = ForumComment::find($comment_id);
        $this->cekOwnership($forumComment->user_id);
        $forumComment->delete();

        return response()->json(['message' => 'Successfully delete Comment']);
    }
}

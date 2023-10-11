<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ForumResource;
use App\Http\Resources\ForumsResource;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{

    use AuthUserTrait;

    public function index()
    {
        return ForumsResource::collection(
            Forum::with('user')->withCount('comments')->paginate(3)
        );
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
        return new ForumResource(Forum::with('user', 'comments.user')->find($id));
    }

    public function filterTag($tag)
    {
        return ForumResource::collection(
            Forum::with('user')->where('category', $tag)->paginate(3)
        );
    }

    public function update(Request $request, string $id)
    {
        $this->validateRequest();

        $forum = Forum::find($id);

        $this->cekOwnership($forum->user_id);

        $forum->update([
            'title' => request('title'),
            'body' => request('body'),
            'category' => request('category')
        ]);

        return response()->json(['message' => 'Successfully updated']);
    }

    public function destroy(string $id)
    {
        $forum = Forum::find($id);
        $this->cekOwnership($forum->user_id);
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
            response()->json($validator->messages(), 422)->send();
            exit;
        }
    }
}

<?php

namespace FoundationApp\Discussions\Controllers;

use Auth;
use Carbon\Carbon;
use FoundationApp\Discussions\Models\Models;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        return view('discussions::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Models::category()->all();

        return view('chatter::discussion.create', compact('categories'));
    }

    public function show($slug)
    {
        if (!isset($slug)) {
            return redirect(config('discussions.home_route'));
        }

        $discussion = Models::discussion()->where('slug', '=', $slug)->first();
        if (is_null($discussion)) {
            return redirect(config('discussions.home_route'));
        }

        $discussion_category = Models::category()->find($discussion->category_id);

        $posts = Models::post()->with('user')->where('discussion_id', '=', $discussion->id)->orderBy('created_at')->paginate(config('discussions.load_more.posts', 10));

        return view('discussions::show', compact('discussion', 'discussion_category', 'posts'));
    }
}

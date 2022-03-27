<?php

namespace App\Http\Controllers;

use App\Models\DestinationComment;
use Illuminate\Http\Request;

class DestinationCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = DestinationComment::isMine(auth()->user())->with('destination')->get();

        return view('comments.index', [
            'data' => $comments
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = DestinationComment::isMine(auth()->user())->with('destination')->find($id);

        return view('comments.show', ['data' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request, $id)
    {
        $user = auth()->user();

        $this->validate($request, [
            'comment' => 'required'
        ], [
            'comment.required' => 'Enter your comment or question'
        ]);

        $parent = DestinationComment::findOrFail($id);

        DestinationComment::create([
            'name' => $user->name,
            'comment' => $request->comment,
            'responder_id' => $user->id,
            'parent_id' => $parent->id,
            'destination_id' => $parent->destination_id
        ]);

        return back()->with('action.success', 'Response submitted');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = DestinationComment::findOrFail($id);

        $comment->delete();

        return to_route('comments.index')->with('action.success', 'Comment deleted');
    }
}

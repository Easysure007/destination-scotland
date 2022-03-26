<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\DestinationComment;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();
        return view('welcome', ['data' => $destinations]);
    }

    public function destinations()
    {
        $destinations = Destination::all();
        return view('destinations', ['data' => $destinations]);
    }

    public function destination($id)
    {
        $destination = Destination::with('comments')->findOrFail($id);

        return view('destination', ['destination' => $destination]);
    }

    public function comment(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'comment' => 'required'
        ], [
            'name.required' => 'Enter your name',
            'comment.required' => 'Enter your comment or question'
        ]);

        DestinationComment::create([
            'destination_id' => $id,
            'name' => $request->name,
            'comment' => $request->comment
        ]);

        return back()->with('action.success', 'Feedback submitted');
    }
}

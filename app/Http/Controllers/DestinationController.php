<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $destinations = Destination::isMine(auth()->user())->get();

        return view('destinations.index', [
            'data' => $destinations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('destinations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:destinations,name',
            'description' => 'required',
            'images.*' => 'required|file|mimetypes:image/*'
        ], [
            'name.required' => 'Name is rquired',
            'name.unique' => 'Destination with name already exists',
            'description' => 'Description is required',
            'images.*.required' => 'Please upload an image',
            'images.*.mimetypes' => 'Only image files are allowed',
        ]);

        $images = $request->file('images');
        $filePaths = [];

        foreach($images  as $image) {
            $destinationPath = 'public/destination-files/'.date('Y-m-d');
            $fileName = time() . rand(10, 9999) . "." . $image->getClientOriginalExtension();
            $stored = $image->storeAs($destinationPath, $fileName);

            $filePaths[] = $stored;
        }

        $destination = Destination::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'images' => json_encode($filePaths),
            'storyteller_id' => auth()->id()
        ]);

        return to_route('destinations.index')->with('action.success', 'Destination added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        $destination =  Destination::isMine($user)->find($id);

        $images = collect(json_decode($destination->images));

        $files = [];
        $images->each(function ($image) use (&$files) {
            $file = Storage::url($image);
            $files[] = [
                'path' => $image,
                'url' => $file,
                'name' => basename($image)
            ];
        });

        return view('destinations.show', ['data' => $destination, 'files' => $files]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = auth()->user();

        $destination = Destination::isMine($user)->findOrFail($id);

        $images = collect(json_decode($destination->images));

        $files = [];
        $images->each(function ($image) use (&$files) {
            $file = Storage::url($image);
            $files[] = [
                'path' => $image,
                'url' => $file,
                'name' => basename($image)
            ];
        });

        return view('destinations.edit', ['data' => $destination, 'files' => $files]);
    }

    public function deleteFile($id, $file)
    {
        $destination = Destination::findOrFail($id);

        $images = json_decode($destination->images);
        $newFiles = [];

        foreach($images as $image) {
            if (basename($image) === $file) {
                Storage::delete($image);
            } else {
                $newFiles[] = $image;
            }
        }

        $destination->update([
            'images' =>  json_encode($newFiles)
        ]);

        return back()->with('action.success', 'Destination image deleted');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:destinations,name,'.$id,
            'description' => 'required',
            'images.*' => 'file|mimetypes:image/*'
        ], [
            'name.required' => 'Name is rquired',
            'name.unique' => 'Destination with name already exists',
            'description' => 'Description is required',
            'images.*.mimetypes' => 'Only image files are allowed',
        ]);

        $user = auth()->user();

        $destination = Destination::isMine($user)->findOrFail($id);

        $uploaded_images = json_decode($destination->images);

        $images = $request->file('images');
        $filePaths = [];

        foreach($images  as $image) {
            $destinationPath = 'public/destination-files/'.date('Y-m-d');
            $fileName = time() . rand(10, 9999) . "." . $image->getClientOriginalExtension();
            $stored = $image->storeAs($destinationPath, $fileName);

            $filePaths[] = $stored;
        }

        $destination = $destination->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'images' => json_encode(array_merge($uploaded_images, $filePaths))
        ]);

        return to_route('destinations.index')->with('action.success', 'Destination updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        $destination = Destination::isMine($user)->findOrFail($id);

        $images = json_decode($destination->images);

        foreach($images as $image) {
            if (Storage::exists($image)) {
                Storage::delete($image);
            }
        }

        $destination->delete();

        return to_route('destinations.index')->with('action.success', 'Destination deleted');
    }
}

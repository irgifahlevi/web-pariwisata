<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search_about = $request->query('search_about');

        if (!empty($search_about)) {
            $about = About::orderBy('id', 'desc')
                ->where('abouts.title', 'like', '%' . $search_about . '%')
                ->where('abouts.row_status', '=', '0') // Filter row_status = 0
                ->paginate(5)->onEachSide(2)->fragment('about');
        } else {
            $about = About::orderBy('id', 'desc')
                ->where('abouts.row_status', '=', '0') // Filter row_status = 0
                ->paginate(5)
                ->onEachSide(2)->fragment('about');
        }
        return View('admin.about.index', compact('about', 'search_about'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'image_about' => 'required|image|mimes:jpeg,png|max:4000',
            ],
            [
                'title.required' => 'Input title tidak boleh kosong.',
                'title.string' => 'Input yang dimasukan tidak valid.',
                'title.max' => 'Maksimal input 255 karakter.',
                'description.string' => 'Input yang dimasukan tidak valid.',
                'description.max' => 'Maksimal input 255 karakter.',
                'image_about.required' => 'Input file tidak boleh kosong.',
                'image_about.image' => 'Input file yang dimasukan tidak valid.',
                'image_about.mimes' => 'Format file yang dimasukan hanya img, jpg, jpeg dan png.',
                'image_about.max' => 'Maksimal ukuran file 4 MB',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ], 400);
        }

        $image = $request->file('image_about');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('public/about', $imageName);
        $imagePath = basename($path);

        $about = new About();

        $value = 0;
        $about->title = $request->title;
        $about->description = $request->description;
        $about->image_about = $imagePath;
        $about->row_status = (string)$value;

        $about->save();

        return response()->json([
            'status' => 200,
            'message' => 'about berhasil di tambahkan'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $aboutID = About::find($id);
        if (!$aboutID) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! about tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $aboutID
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'image_about' => 'nullable|image|mimes:jpeg,png|max:4000',
            ],
            [
                'title.required' => 'Input title tidak boleh kosong.',
                'title.string' => 'Input yang dimasukan tidak valid.',
                'title.max' => 'Maksimal input 255 karakter.',
                'description.string' => 'Input yang dimasukan tidak valid.',
                'description.max' => 'Maksimal input 500 karakter.',
                'image_about.image' => 'Input file yang dimasukan tidak valid.',
                'image_about.mimes' => 'Format file yang dimasukan hanya img, jpg, jpeg dan png.',
                'image_about.max' => 'Maksimal ukuran file 4 MB',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ], 400);
        }

        $about = About::findOrFail($id);

        if ($request->hasFile('image_about')) {
            Storage::delete('public/about/' . $about->image_about);
            $file = $request->file('image_about');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/about/', $fileName);
            $fileImage = basename($path);
            $about->image_about = $fileImage;
        }

        $about->title = $request->title;
        $about->description = $request->description;

        $about->save();

        return response()->json([
            'status' => 200,
            'message' => 'about berhasil di update'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $about = About::find($id);
        if (!$about) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! about tidak ada'
            ], 404);
        }

        $value = 1;
        $about->row_status = (string)$value;

        $about->save();

        return response()->json([
            'status' => 200,
            'message' => 'About berhasil di hapus'
        ], 201);
    }
}

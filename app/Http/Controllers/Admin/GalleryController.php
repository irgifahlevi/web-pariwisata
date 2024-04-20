<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DB;
use Exception;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search_gallery = $request->query('search_gallery');

        if (!empty($search_gallery)) {
            $gallery = Gallery::with(['destinationGallery'])
                ->orderBy('id', 'desc')
                ->where('galleries.title', 'like', '%' . $search_gallery . '%')
                ->where('galleries.row_status', '=', '0') // Filter row_status = 0
                ->paginate(5)->onEachSide(2)->fragment('gallery');
        } else {
            $gallery = Gallery::with(['destinationGallery'])
                ->orderBy('id', 'desc')
                ->where('galleries.row_status', '=', '0') // Filter row_status = 0
                ->paginate(5)
                ->onEachSide(2)->fragment('gallery');
        }
        return View('admin.gallery.index', compact('gallery', 'search_gallery'));
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
        //dd($request);
        $validator = Validator::make(
            $request->all(),
            [
                'destination_id' => 'required|exists:destinations,id',
                'title' => 'nullable|string|max:255',
                'image_gallery' => 'required|image|mimes:jpeg,png|max:6000',
                'descriptions' => 'required|string|max:255',
            ],
            [
                'destination_id.required' => 'Input nama destinasi tidak boleh kosong.',
                'destination_id.exists' => 'Input yang dimasukan tidak valid.',
                'title.string' => 'Input yang dimasukan tidak valid.',
                'title.max' => 'Maksimal input 255 karakter.',
                'image_gallery.required' => 'Input file tidak boleh kosong.',
                'image_gallery.image' => 'Input file yang dimasukan tidak valid.',
                'image_gallery.mimes' => 'Format file yang dimasukan hanya img, jpg, jpeg dan png.',
                'image_gallery.max' => 'Maksimal ukuran file 6 MB',
                'descriptions.required' => 'Input deskripsi tidak boleh kosong.',
                'descriptions.string' => 'Input yang dimasukan tidak valid.',
                'descriptions.max' => 'Maksimal input 255 karakter.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ], 400);
        }

        try {
            DB::transaction(function () use ($request) {
                $image = $request->file('image_gallery');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/gallery', $imageName);
                $imagePath = basename($path);

                // Tabel gallery
                $gallery = new Gallery();
                $value = 0;
                $gallery->destination_id = $request->destination_id;
                $gallery->title = $request->title;
                $gallery->descriptions = $request->descriptions;
                $gallery->image_gallery = $imagePath;
                $gallery->row_status = (string)$value;
                $gallery->save();
            });
        } catch (Exception $e) {
            $errorMessage = "Oops! Terjadi kesalahan dalam penyimpanan data.";
            return response()->json([
                'status' => 500,
                'message' => $errorMessage
            ], 500);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Gallery berhasil di tambahkan'
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
        $galleryID = Gallery::with('destinationGallery')->find($id);
        if (!$galleryID) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! gallery tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $galleryID
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request);
        $validator = Validator::make(
            $request->all(),
            [
                'destination_id' => 'required|exists:destinations,id',
                'title' => 'nullable|string|max:255',
                'image_gallery' => 'nullable|image|mimes:jpeg,png|max:6000',
                'descriptions' => 'required|string|max:255',
            ],
            [
                'destination_id.required' => 'Input nama destinasi tidak boleh kosong.',
                'destination_id.exists' => 'Input yang dimasukan tidak valid.',
                'title.string' => 'Input yang dimasukan tidak valid.',
                'title.max' => 'Maksimal input 255 karakter.',
                'image_gallery.image' => 'Input file yang dimasukan tidak valid.',
                'image_gallery.mimes' => 'Format file yang dimasukan hanya img, jpg, jpeg dan png.',
                'image_gallery.max' => 'Maksimal ukuran file 6 MB',
                'descriptions.required' => 'Input deskripsi tidak boleh kosong.',
                'descriptions.string' => 'Input yang dimasukan tidak valid.',
                'descriptions.max' => 'Maksimal input 255 karakter.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ], 400);
        }

        try {
            DB::transaction(function () use ($request, $id) {

                $gallery = Gallery::findOrFail($id);

                if ($request->hasFile('image_gallery')) {
                    Storage::delete('public/gallery/' . $gallery->image_gallery);
                    $file = $request->file('image_gallery');
                    $fileName = time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('public/gallery/', $fileName);
                    $fileImage = basename($path);
                    $gallery->image_gallery = $fileImage;
                }

                // Tabel gallery
                $gallery->destination_id = $request->destination_id;
                $gallery->title = $request->title;
                $gallery->descriptions = $request->descriptions;
                $gallery->save();
            });
        } catch (Exception $e) {
            $errorMessage = "Oops! Terjadi kesalahan dalam penyimpanan data.";
            return response()->json([
                'status' => 500,
                'message' => $errorMessage
            ], 500);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Gallery berhasil di tambahkan'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::find($id);
        if (!$gallery) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! gallery tidak ada'
            ], 404);
        }

        $value = 1;
        $gallery->row_status = (string)$value;

        $gallery->save();

        return response()->json([
            'status' => 200,
            'message' => 'Gallery berhasil di hapus'
        ], 201);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GuidesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search_guide = $request->query('search_guide');

        if (!empty($search_guide)) {
            $guide = Guide::orderBy('id', 'desc')
                ->where('guides.guide_name', 'like', '%' . $search_guide . '%')
                ->where('guides.row_status', '=', '0') // Filter row_status = 0
                ->paginate(5)->onEachSide(2)->fragment('guide');
        } else {
            $guide = Guide::orderBy('id', 'desc')
                ->where('guides.row_status', '=', '0') // Filter row_status = 0
                ->paginate(5)
                ->onEachSide(2)->fragment('guide');
        }
        return View('admin.guide.index', compact('guide', 'search_guide'));
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
                'guide_name' => 'required|string|max:255',
                'descriptions' => 'nullable|string|max:255',
                'image_guide' => 'required|image|mimes:jpeg,png|max:2000',
                'url_instagram' => 'nullable|string|max:255',
                'url_facebook' => 'nullable|string|max:255',
                'url_whatsapp' => 'nullable|string|max:255',
            ],
            [
                'title.required' => 'Input title tidak boleh kosong.',
                'title.string' => 'Input yang dimasukan tidak valid.',
                'title.max' => 'Maksimal input 255 karakter.',
                'guide_name.required' => 'Input nama tidak boleh kosong.',
                'guide_name.string' => 'Input yang dimasukan tidak valid.',
                'guide_name.max' => 'Maksimal input 255 karakter.',
                'descriptions.string' => 'Input yang dimasukan tidak valid.',
                'descriptions.max' => 'Maksimal input 255 karakter.',
                'image_guide.required' => 'Input file tidak boleh kosong.',
                'image_guide.image' => 'Input file yang dimasukan tidak valid.',
                'image_guide.mimes' => 'Format file yang dimasukan hanya img, jpg, jpeg dan png.',
                'image_guide.max' => 'Maksimal ukuran file 2 MB',
                'url_instagram.string' => 'Input yang dimasukan tidak valid.',
                'url_instagram.max' => 'Maksimal input 255 karakter.',
                'url_facebook.string' => 'Input yang dimasukan tidak valid.',
                'url_facebook.max' => 'Maksimal input 255 karakter.',
                'url_whatsapp.string' => 'Input yang dimasukan tidak valid.',
                'url_whatsapp.max' => 'Maksimal input 255 karakter.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ], 400);
        }


        $image = $request->file('image_guide');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('public/guide', $imageName);
        $imagePath = basename($path);

        $guide = new Guide();

        $value = 0;
        $guide->title = $request->title;
        $guide->guide_name = $request->guide_name;
        $guide->descriptions = $request->descriptions;
        $guide->image_guide = $imagePath;
        $guide->url_instagram = $request->url_instagram;
        $guide->url_facebook = $request->url_facebook;
        $guide->url_whatsapp = $request->url_whatsapp;
        $guide->row_status = (string)$value;

        $guide->save();

        return response()->json([
            'status' => 200,
            'message' => 'Guide berhasil di tambahkan'
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
        $guideID = Guide::find($id);
        if (!$guideID) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! Guide tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $guideID
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
                'guide_name' => 'required|string|max:255',
                'descriptions' => 'nullable|string|max:255',
                'image_guide' => 'nullable|image|mimes:jpeg,png|max:2000',
                'url_instagram' => 'nullable|string|max:255',
                'url_facebook' => 'nullable|string|max:255',
                'url_whatsapp' => 'nullable|string|max:255',
            ],
            [
                'title.required' => 'Input title tidak boleh kosong.',
                'title.string' => 'Input yang dimasukan tidak valid.',
                'title.max' => 'Maksimal input 255 karakter.',
                'guide_name.required' => 'Input nama tidak boleh kosong.',
                'guide_name.string' => 'Input yang dimasukan tidak valid.',
                'guide_name.max' => 'Maksimal input 255 karakter.',
                'descriptions.string' => 'Input yang dimasukan tidak valid.',
                'descriptions.max' => 'Maksimal input 255 karakter.',
                'image_guide.image' => 'Input file yang dimasukan tidak valid.',
                'image_guide.mimes' => 'Format file yang dimasukan hanya img, jpg, jpeg dan png.',
                'image_guide.max' => 'Maksimal ukuran file 2 MB',
                'url_instagram.string' => 'Input yang dimasukan tidak valid.',
                'url_instagram.max' => 'Maksimal input 255 karakter.',
                'url_facebook.string' => 'Input yang dimasukan tidak valid.',
                'url_facebook.max' => 'Maksimal input 255 karakter.',
                'url_whatsapp.string' => 'Input yang dimasukan tidak valid.',
                'url_whatsapp.max' => 'Maksimal input 255 karakter.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ], 400);
        }

        $guide = Guide::findOrFail($id);

        if ($request->hasFile('image_guide')) {
            Storage::delete('public/guide/' . $guide->image_guide);
            $file = $request->file('image_guide');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/guide/', $fileName);
            $fileImage = basename($path);
            $guide->image_guide = $fileImage;
        }

        $guide->title = $request->title;
        $guide->guide_name = $request->guide_name;
        $guide->descriptions = $request->descriptions;
        $guide->url_instagram = $request->url_instagram;
        $guide->url_facebook = $request->url_facebook;
        $guide->url_whatsapp = $request->url_whatsapp;

        $guide->save();

        return response()->json([
            'status' => 200,
            'message' => 'Guide berhasil di update'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guide = Guide::find($id);
        if (!$guide) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! Guide tidak ada'
            ], 404);
        }

        $value = 1;
        $guide->row_status = (string)$value;

        $guide->save();

        return response()->json([
            'status' => 200,
            'message' => 'Guide berhasil di hapus'
        ], 201);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search_slider = $request->query('search_slider');

        if (!empty($search_slider)) {
            $slider = Slider::orderBy('id', 'desc')
                ->where('sliders.title', 'like', '%' . $search_slider . '%')
                ->where('sliders.row_status', '=', '0') // Filter row_status = 0
                ->paginate(5)->onEachSide(2)->fragment('slider');
        } else {
            $slider = Slider::orderBy('id', 'desc')
                ->where('sliders.row_status', '=', '0') // Filter row_status = 0
                ->paginate(5)
                ->onEachSide(2)->fragment('slider');
        }
        return View('admin.slider.index', compact('slider', 'search_slider'));
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
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'image_slider' => 'required|image|mimes:jpeg,png|max:2000',
            ],
            [
                'title.required' => 'Input title tidak boleh kosong.',
                'title.string' => 'Input yang dimasukan tidak valid.',
                'title.max' => 'Maksimal input 255 karakter.',
                'description.string' => 'Input yang dimasukan tidak valid.',
                'description.max' => 'Maksimal input 255 karakter.',
                'image_slider.required' => 'Input file tidak boleh kosong.',
                'image_slider.image' => 'Input file yang dimasukan tidak valid.',
                'image_slider.mimes' => 'Format file yang dimasukan hanya img, jpg, jpeg dan png.',
                'image_slider.max' => 'Maksimal ukuran file 2 MB',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ], 400);
        }

        $image = $request->file('image_slider');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('public/slider', $imageName);
        $imagePath = basename($path);

        $slider = new Slider();

        $value = 0;
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->image_slider = $imagePath;
        $slider->row_status = (string)$value;

        $slider->save();

        return response()->json([
            'status' => 200,
            'message' => 'Slider berhasil di tambahkan'
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
        $sliderID = Slider::find($id);
        if (!$sliderID) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! Slider tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $sliderID
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
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'image_slider' => 'nullable|image|mimes:jpeg,png|max:2000',
            ],
            [
                'title.required' => 'Input title tidak boleh kosong.',
                'title.string' => 'Input yang dimasukan tidak valid.',
                'title.max' => 'Maksimal input 255 karakter.',
                'description.string' => 'Input yang dimasukan tidak valid.',
                'description.max' => 'Maksimal input 255 karakter.',
                'image_slider.image' => 'Input file yang dimasukan tidak valid.',
                'image_slider.mimes' => 'Format file yang dimasukan hanya img, jpg, jpeg dan png.',
                'image_slider.max' => 'Maksimal ukuran file 2 MB',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ], 400);
        }

        $slider = Slider::findOrFail($id);

        if ($request->hasFile('image_slider')) {
            Storage::delete('public/slider/' . $slider->image_slider);
            $file = $request->file('image_slider');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/slider/', $fileName);
            $fileImage = basename($path);
            $slider->image_slider = $fileImage;
        }

        $slider->title = $request->title;
        $slider->description = $request->description;

        $slider->save();

        return response()->json([
            'status' => 200,
            'message' => 'Slider berhasil di update'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! slider tidak ada'
            ], 404);
        }

        $value = 1;
        $slider->row_status = (string)$value;

        $slider->save();

        return response()->json([
            'status' => 200,
            'message' => 'Slider berhasil di hapus'
        ], 201);
    }
}

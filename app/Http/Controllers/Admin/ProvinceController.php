<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search_province = $request->query('search_province');

        if (!empty($search_province)) {
            $province = Province::orderBy('id', 'desc')
                ->where('provinces.province_name', 'like', '%' . $search_province . '%')
                ->where('provinces.row_status', '=', '0') // Filter row_status = 0
                ->paginate(5)->onEachSide(2)->fragment('province');
        } else {
            $province = Province::orderBy('id', 'desc')
                ->where('provinces.row_status', '=', '0') // Filter row_status = 0
                ->paginate(5)
                ->onEachSide(2)->fragment('province');
        }
        return View('admin.province.index', compact('province', 'search_province'));
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
                'province_name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'descriptions' => 'nullable|string|max:1000',
                'image_province' => 'required|image|mimes:jpeg,png|max:5000',
            ],
            [
                'province_name.required' => 'Input nama provinsi tidak boleh kosong.',
                'province_name.string' => 'Input yang dimasukan tidak valid.',
                'province_name.max' => 'Maksimal input 255 karakter.',
                'title.required' => 'Input title tidak boleh kosong.',
                'title.string' => 'Input yang dimasukan tidak valid.',
                'title.max' => 'Maksimal input 255 karakter.',
                'descriptions.string' => 'Input yang dimasukan tidak valid.',
                'descriptions.max' => 'Maksimal input 1000 karakter.',
                'image_province.required' => 'Input file tidak boleh kosong.',
                'image_province.image' => 'Input file yang dimasukan tidak valid.',
                'image_province.mimes' => 'Format file yang dimasukan hanya img, jpg, jpeg dan png.',
                'image_province.max' => 'Maksimal ukuran file 5 MB',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ], 400);
        }

        $image = $request->file('image_province');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('public/province', $imageName);
        $imagePath = basename($path);

        $province = new Province();

        $value = 0;
        $province->province_name = $request->province_name;
        $province->title = $request->title;
        $province->descriptions = $request->descriptions;
        $province->image_province = $imagePath;
        $province->row_status = (string)$value;

        $province->save();

        return response()->json([
            'status' => 200,
            'message' => 'province berhasil di tambahkan'
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
        $provinceID = Province::find($id);
        if (!$provinceID) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! Province tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $provinceID
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
                'province_name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'descriptions' => 'nullable|string|max:1000',
                'image_province' => 'nullable|image|mimes:jpeg,png|max:5000',
            ],
            [
                'province_name.required' => 'Input nama provinsi tidak boleh kosong.',
                'province_name.string' => 'Input yang dimasukan tidak valid.',
                'province_name.max' => 'Maksimal input 255 karakter.',
                'title.required' => 'Input title tidak boleh kosong.',
                'title.string' => 'Input yang dimasukan tidak valid.',
                'title.max' => 'Maksimal input 255 karakter.',
                'descriptions.string' => 'Input yang dimasukan tidak valid.',
                'descriptions.max' => 'Maksimal input 1000 karakter.',
                'image_province.image' => 'Input file yang dimasukan tidak valid.',
                'image_province.mimes' => 'Format file yang dimasukan hanya img, jpg, jpeg dan png.',
                'image_province.max' => 'Maksimal ukuran file 5 MB',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ], 400);
        }

        $province = Province::findOrFail($id);

        if ($request->hasFile('image_province')) {
            Storage::delete('public/province/' . $province->image_province);
            $file = $request->file('image_province');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/province/', $fileName);
            $fileImage = basename($path);
            $province->image_province = $fileImage;
        }

        $province->province_name = $request->province_name;
        $province->title = $request->title;
        $province->descriptions = $request->descriptions;

        $province->save();

        return response()->json([
            'status' => 200,
            'message' => 'Province berhasil di update'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $province = Province::find($id);
        if (!$province) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! Province tidak ada'
            ], 404);
        }

        $value = 1;
        $province->row_status = (string)$value;

        $province->save();

        return response()->json([
            'status' => 200,
            'message' => 'Province berhasil di hapus'
        ], 201);
    }

    public function GetProvince()
    {
        $provinces = Province::select('id', 'province_name')
            ->where('provinces.row_status', '=', '0') // Filter row_status = 0
            ->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => 200,
            'data' => $provinces
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DB;
use Exception;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search_destination = $request->query('search_destination');

        if (!empty($search_destination)) {
            $destination = Destination::with(['province', 'detail'])
                ->orderBy('id', 'desc')
                ->where('destinations.destination_name', 'like', '%' . $search_destination . '%')
                ->where('destinations.row_status', '=', '0') // Filter row_status = 0
                ->paginate(5)->onEachSide(2)->fragment('destination');
        } else {
            $destination = Destination::with(['province', 'detail'])
                ->orderBy('id', 'desc')
                ->where('destinations.row_status', '=', '0') // Filter row_status = 0
                ->paginate(5)
                ->onEachSide(2)->fragment('destination');
        }
        return View('admin.destination.index', compact('destination', 'search_destination'));
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
                'province_id' => 'required|exists:provinces,id',
                'title' => 'nullable|string|max:255',
                'destination_name' => 'required|string|max:255',
                'image_destination' => 'required|image|mimes:jpeg,png|max:6000',
                'rating' => 'required|numeric|between:10,100',
                'descriptions' => 'required|string|max:1000',
                'url_locations' => 'required|string|max:1000'
            ],
            [
                'province_id.required' => 'Input nama provinsi tidak boleh kosong.',
                'province_id.exists' => 'Input yang dimasukan tidak valid.',
                'title.string' => 'Input yang dimasukan tidak valid.',
                'title.max' => 'Maksimal input 225 karakter.',
                'destination_name.required' => 'Input nama provinsi tidak boleh kosong.',
                'destination_name.string' => 'Input yang dimasukan tidak valid.',
                'destination_name.max' => 'Maksimal input 225 karakter.',
                'image_destination.required' => 'Input file tidak boleh kosong.',
                'image_destination.image' => 'Input file yang dimasukan tidak valid.',
                'image_destination.mimes' => 'Format file yang dimasukan hanya img, jpg, jpeg dan png.',
                'image_destination.max' => 'Maksimal ukuran file 6 MB',
                'rating.required' => 'Input rating tidak boleh kosong.',
                'rating.numeric' => 'Input nilai yang dimasukkan adalah angka.',
                'rating.between' => 'Input nilai yang dimasukkan rentang antara 10 hingga 100.',
                'descriptions.required' => 'Input deskripsi tidak boleh kosong.',
                'descriptions.string' => 'Input yang dimasukan tidak valid.',
                'descriptions.max' => 'Maksimal input 1000 karakter.',
                'url_locations.required' => 'Input lokasi tidak boleh kosong.',
                'url_locations.string' => 'Input yang dimasukan tidak valid.',
                'url_locations.max' => 'Maksimal input 1000 karakter.',
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
                $image = $request->file('image_destination');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/destination', $imageName);
                $imagePath = basename($path);

                // Tabel destinasi
                $destination = new Destination();
                $value = 0;
                $destination->province_id = $request->province_id;
                $destination->title = $request->title;
                $destination->destination_name = $request->destination_name;
                $destination->image_destination = $imagePath;
                $destination->rating = $request->rating;
                $destination->row_status = (string)$value;
                $destination->save();

                $destinationId = $destination->id;

                // Tabel detail
                $detail = new Detail();
                $detail->destination_id = $destinationId; // mengambil daridestination yang baru saja ke save
                $detail->title = $request->title;
                $detail->descriptions = $request->descriptions;
                $detail->url_locations = $request->url_locations;
                $detail->row_status = (string)$value;
                $detail->save();
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
            'message' => 'Destination berhasil di tambahkan'
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
        $destinationID = Destination::with('detail')->find($id);
        if (!$destinationID) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! destinasi tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $destinationID
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
                'province_id' => 'required|exists:provinces,id',
                'title' => 'nullable|string|max:255',
                'destination_name' => 'required|string|max:255',
                'image_destination' => 'nullable|image|mimes:jpeg,png|max:6000',
                'rating' => 'required|numeric|between:10,100',
                'descriptions' => 'required|string|max:1000',
                'url_locations' => 'required|string|max:1000'
            ],
            [
                'province_id.required' => 'Input nama provinsi tidak boleh kosong.',
                'province_id.exists' => 'Input yang dimasukan tidak valid.',
                'title.string' => 'Input yang dimasukan tidak valid.',
                'title.max' => 'Maksimal input 255 karakter.',
                'destination_name.required' => 'Input nama provinsi tidak boleh kosong.',
                'destination_name.string' => 'Input yang dimasukan tidak valid.',
                'destination_name.max' => 'Maksimal input 255 karakter.',
                'image_destination.image' => 'Input file yang dimasukan tidak valid.',
                'image_destination.mimes' => 'Format file yang dimasukan hanya img, jpg, jpeg dan png.',
                'image_destination.max' => 'Maksimal ukuran file 6 MB',
                'rating.required' => 'Input rating tidak boleh kosong.',
                'rating.numeric' => 'Input nilai yang dimasukkan adalah angka.',
                'rating.between' => 'Input nilai yang dimasukkan rentang antara 10 hingga 100.',
                'descriptions.required' => 'Input deskripsi tidak boleh kosong.',
                'descriptions.string' => 'Input yang dimasukan tidak valid.',
                'descriptions.max' => 'Maksimal input 1000 karakter.',
                'url_locations.required' => 'Input lokasi tidak boleh kosong.',
                'url_locations.string' => 'Input yang dimasukan tidak valid.',
                'url_locations.max' => 'Maksimal input 1000 karakter.',
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

                $destination = Destination::findOrFail($id);

                if ($request->hasFile('image_destination')) {
                    Storage::delete('public/destination/' . $destination->image_destination);
                    $file = $request->file('image_destination');
                    $fileName = time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('public/destination/', $fileName);
                    $fileImage = basename($path);
                    $destination->image_destination = $fileImage;
                }

                // Tabel destinasi
                $value = 0;
                $destination->province_id = $request->province_id;
                $destination->title = $request->title;
                $destination->destination_name = $request->destination_name;
                $destination->rating = $request->rating;
                $destination->save();

                $destinationId = $destination->id;

                // Tabel detail
                $detail = Detail::FindOrFail($request->id_detail);
                $detail->destination_id = $destinationId; // mengambil daridestination yang baru saja ke save
                $destination->title = $request->title;
                $detail->descriptions = $request->descriptions;
                $detail->url_locations = $request->url_locations;
                $detail->save();
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
            'message' => 'Destinasi berhasil di update'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destination = destination::find($id);
        if (!$destination) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! destinasi tidak ada'
            ], 404);
        }

        try {
            DB::transaction(function () use ($id) {
                $destination = destination::find($id);
                // Tabel destinasi
                $value = 1;
                $destination->row_status = (string)$value;
                $destination->save();

                // Update row_status di tabel Detail yang terkait
                $destination->detail()->update(['row_status' => (string)$value]);
            });
        } catch (Exception $e) {
            $errorMessage = "Oops! Terjadi kesalahan dalam penghapusan data.";
            return response()->json([
                'status' => 500,
                'message' => $errorMessage
            ], 500);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Destinasi berhasil di hapus'
        ], 201);
    }

    public function GetDestination()
    {
        $destinations = Destination::select('id', 'destination_name')
            ->where('destinations.row_status', '=', '0') // Filter row_status = 0
            ->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => 200,
            'data' => $destinations
        ], 200);
    }
}

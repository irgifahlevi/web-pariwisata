<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Exception;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
                'destination_id' => 'required|exists:destinations,id',
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'descriptions' => 'required|string|max:255',
            ],
            [
                'destination_id.required' => 'Input nama destinasi tidak boleh kosong.',
                'destination_id.exists' => 'Input yang dimasukan tidak valid.',
                'name.required' => 'Input nama tidak boleh kosong.',
                'name.string' => 'Input yang dimasukan tidak valid.',
                'name.max' => 'Maksimal input 255 karakter.',
                'email.required' => 'Input email tidak boleh kosong.',
                'email.email' => 'Email tidak valid.',
                'descriptions.required' => 'Input saran tidak boleh kosong.',
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

                $suggestions = new Suggestion();
                $suggestions->destination_id = $request->destination_id;
                $suggestions->name = $request->name;
                $suggestions->email = $request->email;
                $suggestions->descriptions = $request->descriptions;

                $suggestions->save();
            });
        } catch (Exception $e) {
            $errorMessage = "Oops! Terjadi kesalahan dalam pengiriman data.";
            return response()->json([
                'status' => 500,
                'message' => $errorMessage
            ], 500);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Saran berhasil di krim, silahkan menunggu balasan via email'
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

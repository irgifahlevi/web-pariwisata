<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Exception;

class TicketController extends Controller
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
        //dd($request);
        $validator = Validator::make(
            $request->all(),
            [
                'destination_id' => 'required|exists:destinations,id',
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'capacity' => 'required|numeric|between:1,100',
            ],
            [
                'destination_id.required' => 'Input nama destinasi tidak boleh kosong.',
                'destination_id.exists' => 'Input yang dimasukan tidak valid.',
                'name.required' => 'Input nama tidak boleh kosong.',
                'name.string' => 'Input yang dimasukan tidak valid.',
                'name.max' => 'Maksimal input 255 karakter.',
                'email.required' => 'Input email tidak boleh kosong.',
                'email.email' => 'Email tidak valid.',
                'capacity.required' => 'Input kapasitas tidak boleh kosong.',
                'capacity.numeric' => 'Input nilai yang dimasukkan adalah angka.',
                'capacity.between' => 'Input nilai yang dimasukkan rentang antara 1 hingga 100.',
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
                $destination = Destination::find($request->destination_id);

                $tick = 'TICK';
                $destinationName = $destination->destination_name;

                // Menggunakan ekspresi reguler untuk mengambil dua kata terakhir
                if (preg_match('/\b(\w+\s+\w+)$/', $destinationName, $matches)) {
                    $lastTwoWords = $matches[1];
                } else {
                    // Jika tidak ditemukan dua kata terakhir, gunakan seluruh string
                    $lastTwoWords = $destinationName;
                }

                // Mengganti spasi dengan tanda "-" dan mengonversi ke huruf besar
                $lastTwoWords = strtoupper(str_replace(' ', '-', $lastTwoWords));

                $dateNow = now()->format('dmy'); // Format tanggal saat ini (misalnya, DDMMYY)

                $lastTicket = Ticket::where('destination_id', $request->destination_id)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($lastTicket) {
                    $lastNumber = (int)substr($lastTicket->transaction_code, -3);
                    $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
                } else {
                    $newNumber = '001';
                }

                $transactionCode = "$tick-$lastTwoWords-$dateNow-$newNumber";

                $ticket = new Ticket();
                $ticket->destination_id = $request->destination_id;
                $ticket->transaction_code = $transactionCode;
                $ticket->name = $request->name;
                $ticket->email = $request->email;
                $ticket->capacity = $request->capacity;

                $ticket->save();
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
            'message' => 'Pemesanan berhasil dibuat, silahkan menunggu balasan email'
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

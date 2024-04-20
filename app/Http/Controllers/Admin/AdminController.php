<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\ProdukMasuk;
use App\Models\ProdukKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nakes;
use App\Models\Suggestion;
use App\Models\Supplier;
use App\Models\Ticket;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // $jumlahProdukMasuk = ProdukMasuk::count();
        // $jumlahKategori = Kategori::count();
        // $jumlahProduk = Produk::count();
        // $supplierActive = Supplier::where('status', 'active')->count();
        // $nakesActive = Nakes::where('status', 'active')->count();
        // $jumlahStaff = User::where('role', 'staff')->count();
        // $jumlahProdukKeluar = ProdukKeluar::count();
        // $produkKeluarApproved = ProdukKeluar::where('status', 'aproved')->count();
        // $produkKeluarPending = ProdukKeluar::where('status', 'pending')->count();
        // $supplierInactive = Supplier::where('status', 'inactive')->count();
        // $nakesInactive = Nakes::where('status', 'inactive')->count();

        return view('Admin.admin_index');
    }

    // sections suggestion
    public function suggestions(Request $request)
    {
        $search_suggestion = $request->query('search_suggestion');

        $suggestion = Suggestion::with(['destinationSuggestion'])
            ->orderBy('id', 'desc')
            ->where('suggestions.row_status', '=', '0'); // Filter row_status = 0

        if (!empty($search_suggestion)) {
            $suggestion->whereHas('destinationSuggestion', function ($query) use ($search_suggestion) {
                $query->where('destination_name', 'like', '%' . $search_suggestion . '%');
            });
        }

        $suggestion = $suggestion->paginate(5)->onEachSide(2)->fragment('suggestion');

        return view('admin.suggestion.index', compact('suggestion', 'search_suggestion'));
    }

    public function showSugestion($id)
    {
        $suggestionID = suggestion::with('destinationSuggestion')->find($id);
        if (!$suggestionID) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! Suggestion tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $suggestionID
        ], 200);
    }


    // sections ticket
    public function tickets(Request $request)
    {
        $search_ticket = $request->query('search_ticket');

        $ticket = Ticket::with(['destinationTicket'])
            ->orderBy('id', 'desc')
            ->where('tickets.row_status', '=', '0'); // Filter row_status = 0

        if (!empty($search_ticket)) {
            $ticket->whereHas('destinationTicket', function ($query) use ($search_ticket) {
                $query->where('destination_name', 'like', '%' . $search_ticket . '%');
            });
        }

        $ticket = $ticket->paginate(5)->onEachSide(2)->fragment('ticket');

        return view('admin.ticket.index', compact('ticket', 'search_ticket'));
    }

    public function showTicket($id)
    {
        $ticketID = ticket::with('destinationTicket')->find($id);
        if (!$ticketID) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! Ticket tidak ada'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $ticketID
        ], 200);
    }
}

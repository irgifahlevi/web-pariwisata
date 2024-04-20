<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\Guide;
use App\Models\Province;
use App\Models\Slider;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $slider = Slider::orderBy('id', 'desc')
            ->where('sliders.row_status', '=', '0') // Filter row_status = 0
            ->paginate(4)
            ->onEachSide(2)->fragment('slider');
        $about = About::orderBy('id', 'desc')
            ->where('abouts.row_status', '=', '0') // Filter row_status = 0
            ->paginate(1)
            ->onEachSide(2)->fragment('about');

        $search_destination = $request->query('search_destination');
        $province = Province::where('row_status', '0')
            ->orderBy('id', 'desc'); // Filter row_status = 0

        $destination = Destination::with(['province'])
            ->orderBy('id', 'desc')
            ->where('row_status', '0'); // Filter row_status = 0

        if (!empty($search_destination)) {
            $province->where('province_name', 'like', '%' . $search_destination . '%');
            $destination->where('destination_name', 'like', '%' . $search_destination . '%');
        }
        if (!empty($search_destination)) {
            $destination->orWhereHas('province', function ($query) use ($search_destination) {
                $query->where('province_name', 'like', '%' . $search_destination . '%');
            });
        }

        $province = $province->paginate(9)->onEachSide(2)->fragment('province');
        $destination = $destination->paginate(9);

        $guide = Guide::orderBy('id', 'desc')
            ->where('guides.row_status', '=', '0') // Filter row_status = 0
            ->paginate(9)
            ->onEachSide(2)->fragment('guide');

        $gallery_asc = Gallery::with('destinationGallery')
            ->orderBy('id', 'asc')
            ->where('galleries.row_status', '=', '0') // Filter row_status = 0
            ->paginate(6)
            ->onEachSide(2)->fragment('gallery');

        $gallery_desc = Gallery::with('destinationGallery')
            ->orderBy('id', 'desc')
            ->where('galleries.row_status', '=', '0') // Filter row_status = 0
            ->paginate(6)
            ->onEachSide(2)->fragment('gallery');

        return view('user_public.index_public', compact('slider', 'about', 'province', 'destination', 'guide', 'search_destination', 'gallery_asc', 'gallery_desc'));
    }

    public function viewDestination(Request $request, $id)
    {
        $destination = Destination::with('province', 'detail')->find($id);
        if ($destination == null) {
            return response()->json([
                'status' => 404,
                'message' => 'Oops! Destinasi tidak ada'
            ], 404);
        }


        $destinationAll = Destination::with(['province'])
            ->orderBy('id', 'desc')
            ->where('row_status', '0') // Filter row_status = 0
            ->where('id', '!=', $id)
            ->paginate(5);

        $destinationAllAsc = Destination::with(['province'])
            ->orderBy('id', 'asc')
            ->where('row_status', '0') // Filter row_status = 0
            ->where('id', '!=', $id)
            ->paginate(4);

        $gallery = $destination->gallery;


        // dd($destination->detail->url_locations);

        return view('user_public.destination_view', compact('destination', 'gallery', 'destinationAll', 'destinationAllAsc'));
    }
}

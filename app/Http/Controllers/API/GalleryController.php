<?php

namespace App\Http\Controllers\API;

use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Gallery\StoreRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    protected $gallery;

    public function __construct(Gallery $gallery)
    {
        $this->gallery = $gallery;
    }

    public function view(Request $request)
    {
        $galleries = $this->gallery->query()
            ->selectRaw('id, image_name, image_path, created_at')
            ->where('category', 0)
            ->paginate($request->per_page);

        return MessageFixer::render([
            "code" => MessageFixer::HTTP_OK,
            "status" => MessageFixer::SUCCESS,
            "data" => $galleries->items(),
            "pagination" => [
                "total" => $galleries->total(),
                "per_page" => $galleries->perPage(),
                "current_page" => $galleries->currentPage(),
                "last_page" => $galleries->lastPage(),
                "next_page_url" => $galleries->nextPageUrl(),
                "prev_page_url" => $galleries->previousPageUrl(),
                "from" => $galleries->firstItem(),
                "to" => $galleries->lastItem(),
            ]
        ]);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            foreach ($request->file('images') as $key => $image) {
                $this->gallery->create([
                    "image_name" => $image->getClientOriginalName(),
                    "image_path" => $image->store('galleries')
                ]);
            }

            DB::commit();
            return MessageFixer::created('image gallery has been added!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        $gallery = $this->gallery->selectRaw('id')->find($id);
        if (!$gallery) {
            return MessageFixer::warning("data not found!", MessageFixer::HTTP_NOT_FOUND);
        }

        try {
            Storage::delete(str_replace(asset('storage') . '/', '', $gallery->image_path));
            $gallery->delete();

            DB::commit();
            return MessageFixer::success('image gallery has been deleted!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }
}

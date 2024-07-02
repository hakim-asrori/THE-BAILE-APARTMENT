<?php

namespace App\Http\Controllers\API;

use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\RoomImage\StoreRequest;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoomImageController extends Controller
{
    protected $roomImage;

    public function __construct(RoomImage $roomImage)
    {
        $this->roomImage = $roomImage;
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        $roomImageCount = $this->roomImage->where('room_id', $request->room_id)->count();
        if ($roomImageCount >= 4) {
            return MessageFixer::warning('image capacity is full!');
        }

        try {
            foreach ($request->file('images') as $image) {
                $this->roomImage->create([
                    'room_id' => $request->room_id,
                    'image' => $image->store('rooms')
                ]);
            }

            DB::commit();
            return MessageFixer::created('room image has been added!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        $roomImage = $this->roomImage->find($id);
        if (!$roomImage) {
            return MessageFixer::warning("data not found!", MessageFixer::HTTP_NOT_FOUND);
        }

        try {
            Storage::delete(str_replace(asset('storage') . '/', '', $roomImage->image));
            $roomImage->delete();

            DB::commit();
            return MessageFixer::success('room image has been deleted!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }
}

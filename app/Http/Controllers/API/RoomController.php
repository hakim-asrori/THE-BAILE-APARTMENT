<?php

namespace App\Http\Controllers\API;

use App\Enums\RoomFeatureEnum;
use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Room\StoreRequest;
use App\Http\Requests\API\Room\UpdateRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    protected $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function view(Request $request)
    {
        $query = $this->room->query();
        $query->selectRaw('id, title, description, created_at');

        if ($request->has('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'like', "%$request->search%");
            });
        }

        $rooms = $query->paginate($request->per_page);

        $data = [];
        foreach ($rooms->items() as $key => $room) {
            $data[$key] = $room;

            foreach ($room->features()->selectRaw('id, name, type as type_id')->get() as $i => $feature) {
                $data[$key]['features'][$i] = $feature;
                $data[$key]['features'][$i]['type_name'] = RoomFeatureEnum::show($feature->type_id);
            }

            foreach ($room->images()->selectRaw('id, image')->get() as $i => $image) {
                $data[$key]['images'][$i] = $image;
            }
        }

        return MessageFixer::render([
            "code" => MessageFixer::HTTP_OK,
            "status" => MessageFixer::SUCCESS,
            "data" => $data,
            "pagination" => [
                "total" => $rooms->total(),
                "per_page" => $rooms->perPage(),
                "current_page" => $rooms->currentPage(),
                "last_page" => $rooms->lastPage(),
                "next_page_url" => $rooms->nextPageUrl(),
                "prev_page_url" => $rooms->previousPageUrl(),
                "from" => $rooms->firstItem(),
                "to" => $rooms->lastItem(),
            ]
        ]);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $room = $this->room->create($request->except('images', 'features'));

            foreach ($request->features as $feature) {
                $room->features()->create($feature);
            }

            foreach ($request->images as $image) {
                $room->images()->create([
                    'image' => $image->store('rooms')
                ]);
            }

            DB::commit();
            return MessageFixer::created('room has been added!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }

    public function show($id)
    {
        $room = $this->room->selectRaw('id, title, description, created_at')->find($id);
        if (!$room) {
            return MessageFixer::warning("data not found!", MessageFixer::HTTP_NOT_FOUND);
        }

        $data = $room;

        foreach ($room->features()->selectRaw('id, name, type as type_id')->get() as $i => $feature) {
            $data['features'][$i] = $feature;
            $data['features'][$i]['type_name'] = RoomFeatureEnum::show($feature->type_id);
        }

        foreach ($room->images()->selectRaw('id, image')->get() as $i => $image) {
            $data['images'][$i] = $image;
        }

        return $data;
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();

        $room = $this->room->selectRaw('id')->find($id);
        if (!$room) {
            return MessageFixer::warning("data not found!", MessageFixer::HTTP_NOT_FOUND);
        }

        try {
            $room->update($request->all());

            DB::commit();
            return MessageFixer::success('room has been updated!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }
}

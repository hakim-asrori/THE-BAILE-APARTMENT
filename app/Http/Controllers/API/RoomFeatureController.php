<?php

namespace App\Http\Controllers\API;

use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\RoomFeature\StoreRequest;
use App\Models\RoomFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomFeatureController extends Controller
{
    protected $roomFeature;

    public function __construct(RoomFeature $roomFeature)
    {
        $this->roomFeature = $roomFeature;
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->roomFeature->create($request->all());

            DB::commit();
            return MessageFixer::created('room feature has been added!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        $roomFeature = $this->roomFeature->find($id);
        if (!$roomFeature) {
            return MessageFixer::warning("data not found!", MessageFixer::HTTP_NOT_FOUND);
        }

        try {
            $roomFeature->delete();

            DB::commit();
            return MessageFixer::success('room feature has been deleted!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }
}

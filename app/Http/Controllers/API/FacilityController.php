<?php

namespace App\Http\Controllers\API;

use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Facility\StoreRequest;
use App\Http\Requests\API\Facility\UpdateRequest;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    protected $facility;

    public function __construct(Facility $facility)
    {
        $this->facility = $facility;
    }

    public function view(Request $request)
    {
        $query = $this->facility->query();
        $query->selectRaw('id, title, thumbnail, description, status, created_at');

        if ($request->has('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'like', "%$request->search%");
            });
        }

        $facilities = $query->paginate($request->per_page);

        $data = [];
        foreach ($facilities->items() as $key => $facility) {
            $data[$key] = $facility;

            foreach ($facility->features()->selectRaw('name')->get() as $i => $feature) {
                $data[$key]['features'][$i] = $feature->name;
            }
        }

        return MessageFixer::render([
            "code" => MessageFixer::HTTP_OK,
            "status" => MessageFixer::SUCCESS,
            "data" => $data,
            "pagination" => [
                "total" => $facilities->total(),
                "per_page" => $facilities->perPage(),
                "current_page" => $facilities->currentPage(),
                "last_page" => $facilities->lastPage(),
                "next_page_url" => $facilities->nextPageUrl(),
                "prev_page_url" => $facilities->previousPageUrl(),
                "from" => $facilities->firstItem(),
                "to" => $facilities->lastItem(),
            ]
        ]);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $request->merge([
                "thumbnail" => $request->file('image')->store('facilities')
            ]);

            $facility = $this->facility->create($request->except('image', 'features'));
            foreach ($request->features as $feature) {
                $facility->features()->create([
                    "icon" => 1,
                    "name" => $feature
                ]);
            }

            DB::commit();
            return MessageFixer::created('facility has been added!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }

    public function show($id)
    {
        $facility = $this->facility->selectRaw('id, title, thumbnail, description, status, created_at')->find($id);
        if (!$facility) {
            return MessageFixer::warning("data not found!", MessageFixer::HTTP_NOT_FOUND);
        }

        $data = $facility;

        foreach ($facility->features()->selectRaw('icon, name')->get() as $i => $feature) {
            $data['features'][$i] = $feature->name;
        }

        return MessageFixer::success("", $data);
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();

        $facility = $this->facility->selectRaw('id, thumbnail')->find($id);
        if (!$facility) {
            return MessageFixer::warning("data not found!", MessageFixer::HTTP_NOT_FOUND);
        }

        try {
            if ($request->hasFile('image')) {
                Storage::delete(str_replace(asset('storage') . '/', '', $facility->thumbnail));
                $request->merge([
                    "thumbnail" => $request->file('image')->store('facilities')
                ]);
            }

            $facility->update($request->except('image', 'features'));
            $facility->features()->delete();
            foreach ($request->features as $feature) {
                $facility->features()->create([
                    "icon" => 1,
                    "name" => $feature
                ]);
            }

            DB::commit();
            return MessageFixer::success('facility has been updated!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        $facility = $this->facility->selectRaw('id, thumbnail')->find($id);
        if (!$facility) {
            return MessageFixer::warning("data not found!", MessageFixer::HTTP_NOT_FOUND);
        }

        try {
            Storage::delete(str_replace(asset('storage') . '/', '', $facility->thumbnail));

            $facility->features()->delete();
            $facility->delete();

            DB::commit();
            return MessageFixer::success('facility has been deleted!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }
}

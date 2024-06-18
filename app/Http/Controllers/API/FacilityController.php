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

    /**
     * @OA\Post(
     *      path="/facility/view",
     *      operationId="Facility View",
     *      tags={"Facility"},
     *      summary="Facility View",
     *      description="Facility View",
     *      @OA\Parameter(
     *          description="Search (by name or email)",
     *          in="query",
     *          name="search",
     *          required=false,
     *          @OA\Schema(type="string"),
     *      ),
     *       @OA\Response(
     *           response="200",
     *           description="successfully!",
     *      ),
     *       @OA\Response(
     *           response="500",
     *           description="internal server error!",
     *      ),
     *  )
     */
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

            foreach ($facility->features()->selectRaw('icon, name')->get() as $i => $feature) {
                $data[$key]['features'][$i] = $feature;
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

    /**
     * @OA\Post(
     *      path="/facility/store",
     *      operationId="Facility Store",
     *      tags={"Facility"},
     *      summary="Facility Store",
     *      description="Facility Store",
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 schema="Facility",
     *                 title="store",
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="features[]",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="icon",
     *                             type="string",
     *                         ),
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *             )
     *         )
     *      ),
     *       @OA\Response(
     *           response="201",
     *           description="created!",
     *      ),
     *       @OA\Response(
     *           response="422",
     *           description="body validation!",
     *      ),
     *       @OA\Response(
     *           response="500",
     *           description="internal server error!",
     *      ),
     *  )
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $request->merge([
                "thumbnail" => $request->file('image')->store('facilities')
            ]);

            $facility = $this->facility->create($request->except('image', 'features'));
            foreach ($request->features as $feature) {
                $facility->features()->create($feature);
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
            $data['features'][$i] = $feature;
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
            foreach ($request->features as $feature) {
                $facility->features()->delete();
                $facility->features()->create($feature);
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

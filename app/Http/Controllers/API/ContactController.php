<?php

namespace App\Http\Controllers\API;

use App\Enums\ContactEnum;
use App\Facades\LogFixer;
use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Contact\StoreRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @OA\Post(
     *      path="/contact/view",
     *      operationId="Contact View",
     *      tags={"Contact"},
     *      summary="Contact View",
     *      description="Contact View",
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
        try {
            $query = $this->contact->query();
            $query->selectRaw('id, name, email, phone, date, time, message, created_at');

            if ($request->has('search')) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%");
                    $query->orWhere('email', 'like', "%$request->search%");
                    $query->orWhere('phone', 'like', "%$request->search%");
                });
            }

            $query->whereType(ContactEnum::CONTACT);

            $contacts = $query->paginate($request->per_page);

            return MessageFixer::render([
                "code" => MessageFixer::HTTP_OK,
                "status" => MessageFixer::SUCCESS,
                "data" => $contacts->items(),
                "pagination" => [
                    "total" => $contacts->total(),
                    "per_page" => $contacts->perPage(),
                    "current_page" => $contacts->currentPage(),
                    "last_page" => $contacts->lastPage(),
                    "next_page_url" => $contacts->nextPageUrl(),
                    "prev_page_url" => $contacts->previousPageUrl(),
                    "from" => $contacts->firstItem(),
                    "to" => $contacts->lastItem(),
                ]
            ]);
        } catch (\Throwable $th) {
            LogFixer::error("CONTACT", json_encode([
                "HEAD" => [
                    "host" => $request->header('host'),
                    "accept" => $request->header('accept'),
                    "content-type" => $request->header('content-type'),
                ],
                "BODY" => $request->all(),
                "RESP" => $th->getMessage()
            ]));
            return MessageFixer::error("Something went wrong!");
        }
    }

    /**
     * @OA\Post(
     *      path="/contact/store",
     *      operationId="Contact Store",
     *      tags={"Contact"},
     *      summary="Contact Store",
     *      description="Contact Store",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 schema="Contact",
     *                 title="store",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="date",
     *                     type="date"
     *                 ),
     *                 @OA\Property(
     *                     property="time",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string"
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

        $request->merge([
            "type" => ContactEnum::CONTACT
        ]);

        try {
            $this->contact->create($request->all());

            DB::commit();
            return MessageFixer::created(messages: "contact has been saved!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }

    /**
     * @OA\Post(
     *      path="/contact/show/{id}",
     *      operationId="Contact Show",
     *      tags={"Contact"},
     *      summary="Contact Show",
     *      description="Contact Show",
     *      @OA\Parameter(
     *          description="ID",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="string"),
     *      ),
     *       @OA\Response(
     *           response="200",
     *           description="successfully!",
     *      ),
     *       @OA\Response(
     *           response="404",
     *           description="not found!",
     *      ),
     *  )
     */
    public function show($id)
    {
        $contact = $this->contact->selectRaw('id, name, email, phone, date, time, message, created_at')->find($id);
        if (!$contact) {
            return MessageFixer::warning("data not found!", MessageFixer::HTTP_NOT_FOUND);
        }

        return MessageFixer::success("", $contact);
    }

    /**
     * @OA\Post(
     *      path="/contact/delete/{id}",
     *      operationId="Contact Delete",
     *      tags={"Contact"},
     *      summary="Contact Delete",
     *      description="Contact Delete",
     *      @OA\Parameter(
     *          description="ID",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="string"),
     *      ),
     *       @OA\Response(
     *           response="200",
     *           description="deleted!",
     *      ),
     *       @OA\Response(
     *           response="404",
     *           description="not found!",
     *      ),
     *       @OA\Response(
     *           response="500",
     *           description="internal server error!",
     *      ),
     *  )
     */
    public function delete($id)
    {
        DB::beginTransaction();

        $contact = $this->contact->selectRaw('id')->find($id);
        if (!$contact) {
            return MessageFixer::warning("data not found!", MessageFixer::HTTP_NOT_FOUND);
        }

        try {
            $contact->delete();

            DB::commit();
            return MessageFixer::success("contact has been deleted!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }
}

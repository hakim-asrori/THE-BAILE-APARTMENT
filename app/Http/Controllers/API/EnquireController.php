<?php

namespace App\Http\Controllers\API;

use App\Enums\ContactEnum;
use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Enquire\StoreRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnquireController extends Controller
{
    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function view(Request $request)
    {
        $query = $this->contact->query();
        $query->selectRaw('contacts.id, contacts.name, contacts.email, contacts.phone, contacts.date, contacts.time, contacts.created_at, rooms.title as title_room');

        if ($request->has('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('contacts.name', 'like', "%$request->search%");
                $query->orWhere('contacts.email', 'like', "%$request->search%");
            });
        }

        $query->leftJoin('rooms', 'contacts.room_id', '=', 'rooms.id');

        $query->whereType(ContactEnum::ENQUIRE);

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
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        $request->merge([
            "type" => ContactEnum::ENQUIRE
        ]);

        try {
            $this->contact->create($request->all());

            DB::commit();
            return MessageFixer::created(messages: "enquire has been saved!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }

    public function show($id)
    {
        $contact = $this->contact->selectRaw('contacts.id, contacts.name, contacts.email, contacts.phone, contacts.date, contacts.time, contacts.created_at, rooms.title as title_room')->leftJoin('rooms', 'contacts.room_id', '=', 'rooms.id')->find($id);
        if (!$contact) {
            return MessageFixer::warning("data not found!", MessageFixer::HTTP_NOT_FOUND);
        }

        return MessageFixer::success("", $contact);
    }

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
            return MessageFixer::success("enquire has been deleted!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Subscription\StoreRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    protected $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function view(Request $request)
    {
        $query = $this->subscription->query();
        $query->selectRaw('id, email, created_at');

        if ($request->has('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('email', 'like', "%$request->search%");
            });
        }

        $subscriptions = $query->paginate($request->per_page);

        return MessageFixer::render([
            "code" => MessageFixer::HTTP_OK,
            "status" => MessageFixer::SUCCESS,
            "data" => $subscriptions->items(),
            "pagination" => [
                "total" => $subscriptions->total(),
                "per_page" => $subscriptions->perPage(),
                "current_page" => $subscriptions->currentPage(),
                "last_page" => $subscriptions->lastPage(),
                "next_page_url" => $subscriptions->nextPageUrl(),
                "prev_page_url" => $subscriptions->previousPageUrl(),
                "from" => $subscriptions->firstItem(),
                "to" => $subscriptions->lastItem(),
            ]
        ]);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->subscription->create($request->all());

            DB::commit();
            return MessageFixer::created('subscription has been saved!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::error($th->getMessage());
        }
    }
}

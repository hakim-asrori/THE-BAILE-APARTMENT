<?php

namespace App\Http\Controllers\API;

use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Facility;
use App\Models\Room;
use App\Models\Subscription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $facility, $room, $contact, $subscription;

    public function __construct(Facility $facility, Room $room, Contact $contact, Subscription $subscription)
    {
        $this->facility = $facility;
        $this->room = $room;
        $this->contact = $contact;
        $this->subscription = $subscription;
    }

    public function index()
    {
        $data = [];

        $data["count_facility"] = $this->facility->count();
        $data["count_room"] = $this->room->count();
        $data["count_contact"] = $this->contact->count();
        $data["count_subscription"] = $this->subscription->count();

        return MessageFixer::render([
            "code" => MessageFixer::HTTP_OK,
            "status" => MessageFixer::SUCCESS,
            "data" => $data,
        ]);
    }
}

# Room

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

            foreach ($room->features()->selectRaw('name, type as type_id')->get() as $i => $feature) {
                $groupedFeatures = array();

                foreach ($room->features()->selectRaw('name, type as type_id')->get() as $i => $feature) {
                    $typeId = $feature->type_id;
                    if (!isset($groupedFeatures[$typeId])) {
                        $groupedFeatures[$typeId] = [
                            'type_id' => $typeId,
                            'type_name' => RoomFeatureEnum::show($feature->type_id),
                            'items' => []
                        ];
                    }

                    $groupedFeatures[$typeId]['items'][] = $feature->name;
                }
            }

            $data[$key]['features'] = array_values($groupedFeatures);

            foreach ($room->images as $i => $image) {
                $data[$key]['images'][$i] = $image->image;
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

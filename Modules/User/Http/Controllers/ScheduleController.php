<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

//use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

//use Modules\Study\Entities\Lesson;
use Modules\User\Entities\Schedule\ScheduleEvent;
use Modules\User\Entities\Schedule\ScheduleEventType;
use Modules\User\Http\Requests\Schedule\CreateScheduleEventRequest;
use Modules\User\Transformers\Schedule\ScheduleEventResource;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $year = (int)$request->get('year', 0);
        $month = (int)$request->get('month', 0);
        $day = (int)$request->get('day', 0);
        $query = ScheduleEvent::whereUserId($request->user('sanctum')->id);
        if ($year > 0) {
            $query = $query->whereYear('date', $year);
        }
        if ($month > 0) {
            $query = $query->whereMonth('date', $month);
        }
        if ($day > 0) {
            $query = $query->whereDay('date', $day);
        }
        return ScheduleEventResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateScheduleEventRequest $request
     * @return ScheduleEventResource
     */
    public function store(CreateScheduleEventRequest $request): ScheduleEventResource
    {
        $event = new ScheduleEvent($request->all());
        $eventType = ScheduleEventType::findOrFail($request->eventTypeId());
        if (in_array($eventType->slug, array_keys(ScheduleEventType::$linked))) {
            $request->validate([
                'link_id' => 'required|numeric|exists:' . ScheduleEventType::$linked[$eventType->slug] . ',id'
            ]);

            $event->title = $event->link->title;
        }
        $event->save();

        return ScheduleEventResource::make($event);
    }

    public function today(Request $request): AnonymousResourceCollection
    {
        return ScheduleEventResource::collection(
            ScheduleEvent::whereUserId($request->user('sanctum')->id)
                ->whereDay('date', now()->day)
                ->get()
        );
    }

//    /**
//     * Show the specified resource.
//     * @param int $id
//     * @return Response
//     */
//    public function show($id)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     * @param Request $request
//     * @param int $id
//     * @return Response
//     */
//    public function update(Request $request, $id)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     * @param int $id
//     * @return Response
//     */
//    public function destroy($id)
//    {
//        //
//    }
}

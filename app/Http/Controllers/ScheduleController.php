<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\ScheduleEventResource;

use App\Models\Schedule\ScheduleEvent;
use App\Models\Schedule\ScheduleEventType;
use Mockery\Exception;

class ScheduleController extends Controller
{
    protected $schedule;

    public function __construct(ScheduleEvent $schedule){
        $this->schedule = $schedule;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = (int)$request->get('year', 0);
        $month = (int)$request->get('month', 0);
        $day = (int)$request->get('day', 0);
        $query = $this->schedule->where('user_id', auth('api')->user()->id);
        if ($year > 0) {
            $query = $query->whereYear('date', $year);
        }
        if ($month > 0) {
            $query = $query->whereMonth('date', $month);
        }
        if ($day > 0) {
            $query = $query->whereDay('date', $day);
        }
        return $query->get();
        //return ScheduleEventResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'event_type_id' => 'required|exists:schedule_event_types,id',
                'title'         => 'required|string',
                'date'          => 'required|date|after:now'
            ]);

            $data = $request->all();
            $user = auth('api')->user();
            $data['user_id'] = $user->id;
            $data['event_type_id'] = (int)$data['event_type_id'];
            $event = $this->schedule->create($data);

            return response()->json([
                "status" => "success",
                "message" => "успішно створено",
                "data" => $event
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                "error" => "could_not_create",
                "message" => $e->getMessage()
            ], 400);
        }
    }

    public function today(Request $request)
    {
        return ScheduleEventResource::collection(
            ScheduleEvent::whereUserId(auth('api')->user()->id)
                ->whereDay('date', now()->day)
                ->get()
        );
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return ScheduleEventResource
     */
    public function destroy(int $id): ScheduleEventResource
    {
        $event = ScheduleEvent::whereUserId(auth('api')->user()->id)->where('id', $id)->firstOrFail();
        $event->delete();
        return ScheduleEventResource::make($event);
    }
}

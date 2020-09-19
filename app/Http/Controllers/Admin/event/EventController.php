<?php

namespace App\Http\Controllers\Admin\event;

use App\Alumnni;
use App\Event;
use App\Faculty;
use App\Http\Controllers\Controller;
use App\Notifications\eventApprove;
use App\Notifications\eventDelete;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Event::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:events',
            'details' => 'required|min:10',
        ]);

        $event=new Event();
        $event->name=$request->name;
        $event->company=$request->company;
        $event->location=$request->location;
        $event->address=$request->address;
        $event->eventDate=$request->eventDate;
        $event->eventStart=$request->eventStart;
        $event->details=$request->details;
        $event->owner=$request->owner;
        $event->verify=1;
        $event->save();

        return response()->json(['msg'=>"Event Added Successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $event=Event::where('id',$id)->first();
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:events,name,' . $id,
            'details' => 'required|min:10',
        ]);

        $event=Event::where('id',$id)->first();
        $event->name=$request->name;
        $event->company=$request->company;
        $event->location=$request->location;
        $event->address=$request->address;
        $event->eventDate=$request->eventDate;
        $event->eventStart=$request->eventStart;
        $event->details=$request->details;

        $event->save();

        return response()->json(['msg'=>"Event Updated Successfully"]);
    }
    private function UserSelect($email){
        $faculty=Faculty::where('email',$email)->first();
        $alumni=Alumnni::where('email',$email)->first();
        if ($faculty){
            return ($faculty);
        }
        if ($alumni){
            return ($alumni);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $event=Event::where('id',$id)->first();
        if ($event->verify == 0){
            $user=$this->UserSelect($event->owner);
            $user-> notify(
                new eventDelete()
            );
        }
        Event::where('id',$id)->delete();
        return response()->json(['msg'=>"Event Deleted Successfully"]);
    }

    public function approve($id){
        $event=Event::where('id',$id)->first();
        $user=$this->UserSelect($event->owner);

        $event->verify=1;
        $event->save();

        $user-> notify(
            new eventApprove()
        );

        return response()->json(['msg'=>'Event Approved']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Status;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events =  Event::all()->sortByDesc('id');

        if(Gate::allows('tl-manage-events')) {
            $events =  Event::all()->where('user_id', Auth::user()->id)->sortByDesc('id');
        }
        if (! (Gate::allows('manage-events') || Gate::allows('tl-manage-events'))) {
            abort(403);
        }

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('manage-events')) {
            abort(403);
        }
        $teamLeaders = User::select("*")->where('role_id', '2')->orWhere('role_id', '1')->get()->sortByDesc('id');
        return view('events.create', compact('teamLeaders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('manage-events')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string',
            'user_id' => 'required|integer',
            'deadline' => 'required|date|after:tomorrow'
        ]);

        $event = new Event();
        $event->name = $request->name;
        if($request->is_active == "on") {
            $event->is_active = 1;
        }else {
            $event->is_active = 0;
        }
        $event->user_id = $request->user_id;
        $event->deadline = $request->deadline;
        $event->save();
        $request->session()->flash('successMsg','You have successfully created the event: '.$event->name.'!');
        return redirect('events');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $event = Event::find($id);
        if (! (Gate::allows('manage-events') || (Auth::user()->role_id == 2 && $event->user_id == Auth::user()->id))) {
            abort(403);
        }
        $statuses = Status::all()->where('event_id', $id);
        $statusCompanies = Status::all()->where('event_id',$id)->map( function($item) {
            return $item->company->id;
        });
        $companies = Company::all()->whereNotIn('id', $statusCompanies);
        $users = User::all()->where('role_id','<','4');
        return view('events.show', compact('event', 'statuses', 'companies', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        if (! Gate::allows('manage-events')) {
            abort(403);
        }
        $event = Event::find($id);
        $teamLeaders = User::select("*")->where('role_id', '2')->orWhere('role_id', '1')->get()->sortByDesc('id');
        return view('events.edit', compact('event', 'teamLeaders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! Gate::allows('manage-events')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string',
            'user_id' => 'required|integer',
            'deadline' => 'required|date|after:tomorrow'
        ]);

        $editedEvent = Event::find($id);
        $editedEvent->name = $request->name;
        if($request->is_active == "on") {
            $editedEvent->is_active = 1;
        }else {
            $editedEvent->is_active = 0;
        }
        $editedEvent->user_id = $request->user_id;
        $editedEvent->deadline = $request->deadline;
        $editedEvent->update();
        $request->session()->flash('successMsg','You have successfully updated the event: '.$request->name.'!');
        return redirect('events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id){
        if (! Gate::allows('manage-events')) {
            abort(403);
        }
        Event::destroy($id);
        session()->flash('successMsg','You have successfully deleted the event!');
        return redirect('events');
    }


    /**
     * Filters list of partners nased on 'naziv'
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        if (! Gate::allows('manage-events')) {
            abort(403);
        }

        $search_text = $_GET['event_search'];
        $events = Event::where('name', 'LIKE', '%'.$search_text.'%')->get();

        return view('events.index', compact('events'));
    }
}

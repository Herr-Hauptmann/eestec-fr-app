<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('manage-statuses')) {
            abort(403);
        }
        return Status::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('manage-statuses')) {
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('manage-statuses')) {
            abort(403);
        }
        // $request->validate([
        //     'event_id' => 'required|integer',
        //     'company_id' => 'required|integer',
        //     'user_id' => 'required|integer',
        //     'status' => 'required|integer'
        // ]);

        $task = new Status();
        $task->event_id = $request->event_id;
        $task->company_id = $request->company_id;
        $task->user_id = $request->user_id;
        $task->status = 1;
        $task->save();
        $request->session()->flash('successMsg','You have successfully created a task!');
        return redirect('events/'.$request->event_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('manage-statuses')) {
            abort(403);
        }
        $status = Status::find($id);
        $userId = Auth::id(); 
        $html = view('status')->with(compact('status', 'userId'))->render();
        return response()->json(['success' => true, 'prikaz_statusa' => $html]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        if (! Gate::allows('manage-statuses')) {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! Gate::allows('manage-statuses')) {
            abort(403);
        }
        $editedStatus = Status::find($id);
        $editedStatus->user_id = $request->user_id;
        $editedStatus->update();
        session()->flash('successMsg','You have successfully updated contacting member of the Task!');
        return back();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        if (! Gate::allows('manage-statuses')) {
            abort(403);
        }
        $editedStatus = Status::find($id);
        $editedStatus->status = $request->status;
        $editedStatus->update();
        session()->flash('successMsg','You have successfully updated the status of the task!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (! Gate::allows('manage-statuses')) {
            abort(403);
        }
        Status::destroy($id);
        session()->flash('successMsg','You have successfully deleted the Task!');
        return back();
    }
}

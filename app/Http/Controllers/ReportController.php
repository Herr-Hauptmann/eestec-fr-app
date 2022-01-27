<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\ReportSubmitted;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Report::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $status_id)
    {
        $request->validate([
            'content' => 'required|string'
        ]);
        $report = new Report();
        $report->content = $request->content;
        $report->status_id = $status_id;
        $report->user_id = Auth::user()->id;
        $report->save();

        $status = Status::find($status_id);
        $teamLead = $status->user;
        $content = Auth::user()->name." just submitted a report for the event: ".$status->event->name." for the company ".$status->company->name.": ".$request->content;

        Mail::to($teamLead)->send(new ReportSubmitted($content, $status->event, $status->company));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        return Report::find($report->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        $editedReport = Report::find($request->id);
        $editedReport->update($request->all());
        return $editedReport;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        return Report::destroy($report->id);
    }

    public function getReports(int $status_id)
    {
        // Fetch Employees by Departmentid
        $reports = Report::all()->where('status_id', $status_id);
        $html = view('report')->with(compact('reports', 'status_id'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }
}

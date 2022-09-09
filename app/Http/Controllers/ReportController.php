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
    public function index()
    {
        return Report::all();
    }

    public function create()
    {
        //
    }

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
        $teamLead = $status->event->teamLeader;
        $userName = Auth::user()->name;
        $content = $request->content;

        Mail::to($teamLead)->send(new ReportSubmitted($content, $status->event, $status->company, $userName, $status->event->teamLeader->name));

        return back();
    }

    public function show(Report $report)
    {
        return Report::find($report->id);
    }

    public function edit(Report $report)
    {
        //
    }

    public function update(Request $request, Report $report)
    {
        $editedReport = Report::find($request->id);
        $editedReport->update($request->all());
        return $editedReport;
    }

    public function destroy(Report $report)
    {
        return Report::destroy($report->id);
    }

    public function getReports(int $status_id)
    {
        $reports = Report::all()->where('status_id', $status_id);
        $html = view('report')->with(compact('reports', 'status_id'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Status;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('manage-companies')) {
            abort(403);
        }
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('manage-companies')) {
            abort(403);
        }
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('manage-companies')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'website' => 'nullable|string',
            'description' => 'nullable|string',
            'comment' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|alpha_num',
            'contact_person' => 'nullable|string'
        ]);

        $company = new Company();
        $company->name = $request->name;
        $company->address = $request->address;
        $company->website = $request->website;
        $company->description = $request->description;
        $company->comment = $request->comment;
        $company->contact_email = $request->contact_email;
        $company->contact_phone = $request->contact_phone;
        $company->contact_person = $request->contact_person;
        $company->save();
        $request->session()->flash('successMsg','You have successfully added the company: '.$request->name.'!');
        return redirect('companies');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $company = Company::find($id);
        $statuses = Status::all()->where('company_id', $company->id)->sortByDesc('id');
        $assigned = false;
        foreach($statuses as $status) {
            if($status->user_id == Auth::user()->id && $status->event->is_active == 1) {
                $assigned = true;
                break;
            }
        }
        if (! (Gate::allows('manage-companies') || (Auth::user()->role_id == 3 && $assigned))) {
            abort(403);
        }
        return view('companies.show', compact('company', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        if (! Gate::allows('manage-companies')) {
            abort(403);
        }
        $company = Company::find($id);
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! Gate::allows('manage-companies')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'website' => 'nullable|string',
            'description' => 'nullable|string',
            'comment' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|alpha_num',
            'contact_person' => 'nullable|string'
        ]);

        $editedCompany = Company::find($id);
        $editedCompany->name = $request->name;
        $editedCompany->address = $request->address;
        $editedCompany->website = $request->website;
        $editedCompany->description = $request->description;
        $editedCompany->comment = $request->comment;
        $editedCompany->contact_email = $request->contact_email;
        $editedCompany->contact_phone = $request->contact_phone;
        $editedCompany->contact_person = $request->contact_person;
        $editedCompany->update();
        $request->session()->flash('successMsg','You have successfully updated the company: '.$request->name.'!');
        return redirect('companies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (! Gate::allows('manage-companies')) {
            abort(403);
        }
        Company::destroy($id);
        session()->flash('successMsg','You have successfully deleted the company!');
        return redirect('companies');
    }

    /**
     * Filters list of partners nased on 'naziv'
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        if (! Gate::allows('manage-companies')) {
            abort(403);
        }

        $search_text = $_GET['company_search'];
        $companies = Company::where('name', 'LIKE', '%'.$search_text.'%')->get();

        return view('companies.index', compact('companies'));
    }
}

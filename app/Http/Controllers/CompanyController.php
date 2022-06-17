<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Status;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use DB;

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

        //Validate and create company
        $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'website' => 'nullable|string',
            'description' => 'nullable|string',
            'comment' => 'nullable|string'
        ]);

        $company = new Company();
        $company->name = $request->name;
        $company->address = $request->address;
        $company->website = $request->website;
        $company->description = $request->description;
        $company->comment = $request->comment;

        $nextID =DB::select("SHOW TABLE STATUS LIKE 'companies'")[0]->Auto_increment;

        //Validate and create company contacts
        $contacts = $request->except(['name', 'address' , 'website', 'description', 'comment', '_token']); 
        for ($i = 1; $i <= sizeof($contacts)/3; $i++) {
            $nameFieldName = "contactName-".$i;
            $emailFieldName = "contactEmail-".$i;
            $numberFieldName = "contactPhoneNumber-".$i;

            $request->validate([
                $nameFieldName => 'required|string',
                $emailFieldName => 'nullable|email',
                $numberFieldName => 'nullable|string'
            ]);
        }
        
        $company->save();

        //Separate loop because we need to first validate everything before saving the contacts
        for ($i = 1; $i <= sizeof($contacts)/3; $i++) {
            $nameFieldName = "contactName-".$i;
            $emailFieldName = "contactEmail-".$i;
            $numberFieldName = "contactPhoneNumber-".$i;

            $contact = new Contact();
            $contact->name = $contacts[$nameFieldName];
            $contact->email = $contacts[$emailFieldName];
            $contact->number = $contacts[$numberFieldName];
            $contact->company_id = $nextID;
            $contact->save();
        }

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
            'comment' => 'nullable|string'
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
        $companyContacts = Contact::where('company_id', $id)->get();
        foreach($companyContacts as $contact)
            Contact::destroy($contact->id);
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

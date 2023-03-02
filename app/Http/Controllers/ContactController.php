<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactController extends Controller
{

  public function __construct(protected CompanyRepository $company)
  {
  }

  public function index(CompanyRepository $company, Request $request)
  {
    DB::enableQueryLog();
    $companies = $this->company->pluck();
    $contacts = Contact::where(function ($query) {
      if ($companyId = request()->query('company_id')) {
        $query->where('company_id', $companyId);
      }
    })->where(function ($query) {
      if ($search = request()->query('search')) {
        $query->where('first_name', 'LIKE', "%$search%");
        $query->orWhere('last_name', 'LIKE', "%$search%");
        $query->orWhere('email', 'LIKE', "%$search%");
        $query->orWhere('phone', 'LIKE', "%$search%");
      }
    })->orderBy((request()->query('orderBy') ? request()->query('orderBy') : 'created_at'), request()->query('orderQueue') ? 'asc' : 'desc')->paginate(10);
    DUMP(DB::getQueryLog());
    // $contactsCollection = Contact::latest()->get();
    // $perPage = 10;
    // $currentPage = request()->query('page', 1);
    // $items = $contactsCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->values();
    // $total = $contactsCollection->count();
    // $contacts = new LengthAwarePaginator($items, $total, $perPage, $currentPage, [
    //   'path' => $request->url(),
    //   'query' => $request->query()
    // ]);
    return view('contacts.index', compact('contacts', 'companies'));
  }

  public function create()
  {
    // dd(request()->is('contacts/create'));
    $companies = $this->company->pluck();
    return view('contacts.create', compact('companies'))->with('contact', new Contact());
  }

  public function edit($id)
  {
    $companies = $this->company->pluck();
    $contact = Contact::findOrFail($id);
    return view('contacts.edit', compact('companies', 'contact', 'id'));
  }

  public function show($id)
  {
    $contact = Contact::findOrFail($id);
    return view('contacts.show', compact('contact', 'id'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'first_name' => 'required|min:3|max:50|string',
      'last_name' => 'required|min:3|max:50|string',
      'email' => 'required|email|unique:contacts,email',
      'phone' => 'nullable',
      'address' => 'nullable',
      'company_id' => 'required|exists:companies,id'
    ]);
    $contact = Contact::create($request->all());
    return redirect()->route('contacts.index')->with('message', 'Contact created successfully');
  }
  public function update(Request $request, $id)
  {
    $request->validate([
      'first_name' => 'required|min:3|max:50|string',
      'last_name' => 'required|min:3|max:50|string',
      'email' => 'required|email',
      'phone' => 'nullable',
      'address' => 'nullable',
      'company_id' => 'required|exists:companies,id'
    ]);
    $contact = Contact::findOrFail($id);
    $contact->update($request->all());
    return redirect()->route('contacts.index')->with('message', 'Contact updated successfully');
  }

  public function destroy($id)
  {
    $contact = Contact::findOrFail($id);
    $contact->delete();
    return redirect()->route('contacts.index')->with('message', 'Contact deleted successfully');
  }
}

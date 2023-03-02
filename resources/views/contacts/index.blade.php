@extends('layouts.main') @section('title', 'All Contacts') @section('content')
<main class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-title">
            <div class="d-flex align-items-center">
              <h2 class="mb-0">All Contacts</h2>
              <div class="ml-auto">
                <a href="{{ route('contacts.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add
                  New</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            @include('contacts._filter')
            @if ($message = session('message'))
            <div class="alert alert-success">{{$message}}</div>
                
            @endif
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <form>
                    <th scope="col"><button type="submit" class="btn btn-sm"># </button></th>
                    <th scope="col"><button type="submit" name="orderBy" id="first_name" onclick="document.getElementById('first_name').value = 'first_name', this.form.submit()" class="btn btn-sm">First Name</button></th>
                    <th scope="col"><button type="submit" name="orderBy" id="Last_name" onclick="document.getElementById('Last_name').value = 'Last_name', this.form.submit()" class="btn btn-sm">Last Name</button></th>
                    <th scope="col"><button type="submit" name="orderBy" id="Phone" onclick="document.getElementById('Phone').value = 'Phone', this.form.submit()" class="btn btn-sm">Phone</button></th>
                    <th scope="col"><button type="submit" name="orderBy" id="Email" onclick="document.getElementById('Email').value = 'Email', this.form.submit()" class="btn btn-sm">Email</button></th>
                    <th scope="col"><button type="submit" name="orderBy" id="Company" onclick="document.getElementById('Company').value = 'Company', this.form.submit()" class="btn btn-sm">Company</button></th>
                    <th scope="col"><button class="btn btn-sm">Actions</button></th>
                    <input type="hidden" name="orderQueue" value="{{(request()->orderQueue == 0 ? 1 : 0)}}">
                    <input type="hidden" name="company_id" value="{{request()->company_id}}">
                    <input type="hidden" name="search" value="{{request()->search}}">
                  </form>
                </tr>
              </thead>
              <tbody>
                @forelse ($contacts as $index => $contact)
                  @include('contacts._contact', ['contact' => $contact, 'index' => $index])
                @empty
                @include('contacts._empty')
                @endforelse
                {{-- @each('contacts._contact', $contacts, 'contact', 'contacts._empty') --}}
              </tbody>
            </table>

            {{$contacts->withQueryString()->links()}}
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

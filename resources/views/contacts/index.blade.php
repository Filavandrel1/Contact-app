<script>
  function gettingParamsFromURL(name) {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const orderQueue = urlParams.get('orderQueue');
    const orderBy = urlParams.get('orderBy');
    if ((orderBy === null || orderBy === name) && orderQueue == 1) {
      document.getElementById('orderQueue').value = 0;
    }else{
      document.getElementById('orderQueue').value = 1;
    }
  } 
  // create a function that displaying column name and arrow icon in direction of sorting
  function displayOrder(name) {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const orderQueue = urlParams.get('orderQueue');
    const orderBy = urlParams.get('orderBy');
    if (orderBy === null || orderBy !== name) {
      return '';
    }
    if (orderQueue == 1) {
      return `<i class="fa fa-arrow-up"></i>`;
    }else{
      return `<i class="fa fa-arrow-down"></i>`;
    }
  }
</script>

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
                    <th scope="col"><button disabled type="submit" class="btn btn-sm"># </button></th>
                    <th scope="col"><button style="width: 120px;" type="submit" name="orderBy" id="first_name" onclick="document.getElementById('first_name').value = 'first_name', gettingParamsFromURL('first_name'), this.form.submit()" class="btn btn-sm">First Name <script>document.write(displayOrder('first_name'))</script></button></th>
                    <th scope="col"><button type="submit" style="width: 120px;" name="orderBy" id="Last_name" onclick="document.getElementById('Last_name').value = 'last_name', gettingParamsFromURL('last_name'), this.form.submit()" class="btn btn-sm">Last Name <script>document.write(displayOrder('last_name'))</script></button></th>
                    <th scope="col"><button disabled type="submit" class="btn btn-sm">Phone</button></th>
                    <th scope="col"><button type="submit" name="orderBy" id="Email" onclick="document.getElementById('Email').value = 'email', gettingParamsFromURL('email'), this.form.submit()" class="btn btn-sm">Email <script>document.write(displayOrder('email'))</script></button></th>
                    <th scope="col"><button disabled type="submit"class="btn btn-sm">Company</button></th>
                    <th scope="col"><button disabled class="btn btn-sm">Actions</button></th>
                    <input type="hidden" name="orderQueue" id="orderQueue">
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

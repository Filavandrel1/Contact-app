<div class="row">
  <div class="col-md-6"></div>
  <div class="col-md-6">
    <form>
      <div class="row">
        <div class="col">@includeif('contacts._company-selection')</div>
        <div class="col">
          <div class="input-group mb-3">
          <input type="text" class="form-control" name="search" value="{{request()->query('search')}}" id="search-input" placeholder="Search..." aria-label="Search..."
          aria-describedby="button-addon2" />
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('search-input').value = '', document.getElementById('search-select').selectedIndex = 0, this.form.submit()"
              @disabled(!request()->filled('search') and !request()->filled('company_id'))
              >
              <i class="fa fa-refresh"></i>
            </button>
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>


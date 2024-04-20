<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar" >
  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
      <div class="nav-item d-flex align-items-center">
        <i class="bx bx-search fs-4 lh-0"></i>
        <form method="GET">
          <input
            type="text"
            class="form-control border-0 shadow-none"
            placeholder="Search..."
            aria-label="Search..."
            value="{{$search_about}}"
            name="search_about"
          />
        </form>
      </div>
    </div>
    <!-- /Search -->
  </div>
</nav>
@extends('layouts.admin.template_master_admin')
@section('content')
@include('layouts.admin.navbar')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div>
      <div class="row">
        <div class="col-lg-12 col-md-12 mb-4">
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-7">
                <div class="card-body">
                  <h5 class="card-title text-primary">Hi, Welcome back {{ Auth::user()->name }} ! 🎉</h5>
                  
                  <p class="mb-4">
                    You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in
                    your profile.
                  </p>

                  <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                </div>
              </div>
              <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                  <img
                    src="{{asset('Template/assets/img/illustrations/man-with-laptop-light.png')}}"
                    height="140"
                    alt="View Badge User"
                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                    data-app-light-img="illustrations/man-with-laptop-light.png"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- <div class="row">
        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img
                    src="{{asset('Template/assets/img/icons/unicons/produkmasuk.png')}}"
                    alt="chart success"
                    class="rounded"
                  />
                </div>
                <div class="dropdown">
                  <button
                    class="btn p-0"
                    type="button"
                    id="cardOpt3"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                    <a class="dropdown-item" href="{{route('produk-masuk.index')}}">Lihat</a>
                  </div>
                </div>
              </div>
              <span class="d-block mb-1">Produk masuk</span>
              <h3 class="card-title mb-2">{{$jumlahProdukMasuk}}</h3>
              <small class="fw-semibold">Transaksi</small>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img
                    src="{{asset('Template/assets/img/icons/unicons/categories.png')}}"
                    alt="Credit Card"
                    class="rounded"
                  />
                </div>
                <div class="dropdown">
                  <button
                    class="btn p-0"
                    type="button"
                    id="cardOpt3"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                    <a class="dropdown-item" href="{{route('kategori.index')}}">Lihat</a>
                  </div>
                </div>
              </div>
              <span class="d-block mb-1">Kategori</span>
              <h3 class="card-title mb-2">{{$jumlahKategori}}</h3>
              <small class="fw-semibold">Kategori</small>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img
                    src="{{asset('Template/assets/img/icons/unicons/product.png')}}"
                    alt="Credit Card"
                    class="rounded"
                  />
                </div>
                <div class="dropdown">
                  <button
                    class="btn p-0"
                    type="button"
                    id="cardOpt3"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                    <a class="dropdown-item" href="{{route('produk.index')}}">Lihat</a>
                  </div>
                </div>
              </div>
              <span class="d-block mb-1">Produk</span>
              <h3 class="card-title mb-2">{{$jumlahProduk}}</h3>
              <small class="fw-semibold">Item</small>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="{{asset('Template/assets/img/icons/unicons/supplier.png')}}" alt="Credit Card" class="rounded" />
                </div>
                <div class="dropdown">
                  <button
                    class="btn p-0"
                    type="button"
                    id="cardOpt4"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                    <a class="dropdown-item" href="{{route('supplier.index')}}">Lihat</a>
                  </div>
                </div>
              </div>
              <span class="d-block mb-1">Supplier</span>
              <h3 class="card-title mb-2">{{$supplierActive}}</h3>
              <small class="text-success fw-semibold">Active</small>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="{{asset('Template/assets/img/icons/unicons/user (1).png')}}" alt="Credit Card" class="rounded" />
                </div>
                <div class="dropdown">
                  <button
                    class="btn p-0"
                    type="button"
                    id="cardOpt1"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="cardOpt1">
                    <a class="dropdown-item" href="{{route('nakes.index')}}">Lihat</a>
                  </div>
                </div>
              </div>
              <span class="d-block mb-1">Nakes</span>
              <h3 class="card-title mb-2">{{$nakesActive}}</h3>
              <small class="text-success fw-semibold">Active</small>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="{{asset('Template/assets/img/icons/unicons/nakes.png')}}" alt="Credit Card" class="rounded" />
                </div>
                <div class="dropdown">
                  <button
                    class="btn p-0"
                    type="button"
                    id="cardOpt1"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="cardOpt1">
                    <a class="dropdown-item" href="{{route('staff-pegawai.index')}}">Lihat</a>
                  </div>
                </div>
              </div>
              <span class="d-block mb-1">Staff</span>
              <h3 class="card-title mb-2">{{$jumlahStaff}}</h3>
              <small class="fw-semibold">Akun</small>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img
                    src="{{asset('Template/assets/img/icons/unicons/produkkeluar.png')}}"
                    alt="chart success"
                    class="rounded"
                  />
                </div>
                <div class="dropdown">
                  <button
                    class="btn p-0"
                    type="button"
                    id="cardOpt3"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                    <a class="dropdown-item" href="{{route('semua.list_produk_keluar')}}">Lihat</a>
                  </div>
                </div>
              </div>
              <span class="d-block mb-1">Produk keluar</span>
              <h3 class="card-title mb-2">{{$jumlahProdukKeluar}}</h3>
              <small class="fw-semibold">Transaksi</small>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img
                    src="{{asset('Template/assets/img/icons/unicons/expired.png')}}"
                    alt="Credit Card"
                    class="rounded"
                  />
                </div>
                <div class="dropdown">
                  <button
                    class="btn p-0"
                    type="button"
                    id="cardOpt3"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                    <a class="dropdown-item" href="{{route('semua.list_produk_keluar')}}">Lihat</a>
                  </div>
                </div>
              </div>
              <span class="d-block mb-1">Produk keluar</span>
              <h3 class="card-title mb-2">{{$produkKeluarPending}}</h3>
              <small class="text-danger fw-semibold">Pending</small>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="{{asset('Template/assets/img/icons/unicons/check.png')}}" alt="Credit Card" class="rounded" />
                </div>
                <div class="dropdown">
                  <button
                    class="btn p-0"
                    type="button"
                    id="cardOpt4"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                    <a class="dropdown-item" href="{{route('semua.list_produk_keluar')}}">Lihat</a>
                  </div>
                </div>
              </div>
              <span class="d-block mb-1">Produk keluar</span>
              <h3 class="card-title text-nowrap mb-2">{{$produkKeluarApproved}}</h3>
              <small class="text-success fw-semibold">Aproved</small>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="{{asset('Template/assets/img/icons/unicons/supplier.png')}}" alt="Credit Card" class="rounded" />
                </div>
                <div class="dropdown">
                  <button
                    class="btn p-0"
                    type="button"
                    id="cardOpt1"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="cardOpt1">
                    <a class="dropdown-item" href="{{route('supplier.index')}}">Lihat</a>
                  </div>
                </div>
              </div>
              <span class="d-block mb-1">Supplier</span>
              <h3 class="card-title mb-2">{{$supplierInactive}}</h3>
              <small class="text-danger fw-semibold">Inactive</small>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="{{asset('Template/assets/img/icons/unicons/user (1).png')}}" alt="Credit Card" class="rounded" />
                </div>
                <div class="dropdown">
                  <button
                    class="btn p-0"
                    type="button"
                    id="cardOpt1"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="cardOpt1">
                    <a class="dropdown-item" href="{{route('nakes.index')}}">Lihat</a>
                  </div>
                </div>
              </div>
              <span class="d-block mb-1">Nakes</span>
              <h3 class="card-title mb-2">{{$nakesInactive}}</h3>
              <small class="text-danger fw-semibold">Inactive</small>
            </div>
          </div>
        </div>
      </div> --}}
    </div>
  </div>
  {{-- Footer --}}
  @include('layouts.admin.footer')

  <div class="content-backdrop fade"></div>
</div>
@endsection
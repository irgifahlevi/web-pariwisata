@extends('layouts.admin.template_master_admin')
@section('content')
@include('admin.ticket.search')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kelola Ticket /</span> Ticet</h4>
    <div class="row justify-content-center">
      <div class="col-md-12">

        {{-- Jika jumlah data banner lebih dari 0 --}}
        @if (count($ticket) > 0)

          {{-- Tabel --}}
          <div class="card">
            <h5 class="card-header">Data pemesanan ticket</h5>
            <div class="card-body">
              <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nama destinasi</th>
                      <th>Gambar destinasi</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>No Transaksi</th>
                      <th>Kapasitas</th>
                      <th>Tanggal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $nomor = 1 + (($ticket->currentPage() - 1) * $ticket->perPage());
                    @endphp
                    @foreach($ticket as $item)
                    <tr>
                      <td>{{$nomor++}}</td>
                      <td><span class="d-inline-block text-truncate" style="max-width: 164px;">{{ $item->destinationTicket->destination_name }}</span></td>
                      <td>
                        <div class="align-items-center">
                          <img src="{{ asset('storage/destination/' . $item->destinationTicket->image_destination) }}" alt="{{ $item->destinationTicket->image_destination }}" class="w-px-50 h-auto" />
                        </div>
                      </td>
                      <td><span class="d-inline-block text-truncate" style="max-width: 164px;">{{ $item->name }}</span></td>
                      <td><span class="d-inline-block text-truncate" style="max-width: 164px;">{{ $item->email }}</span></td>
                      <td><span class="d-inline-block text-truncate" style="max-width: 164px;">{{ $item->transaction_code }}</span></td>
                      <td><span class="d-inline-block text-truncate" style="max-width: 164px;">{{ $item->capacity }}</span></td>
                      <td><span class="d-inline-block text-truncate" style="max-width: 164px;">{{ $item->created_at }}</span></td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <button class="dropdown-item" type="button" id="view-ticket" data-id="{{$item->id}}">
                              <i class="bx bx bxs-show me-1"></i>
                              View
                            </button>
                          </div>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="mt-3">
                  <!-- {{-- {{ $dataBarang->links() }} --}} -->
                  {!! $ticket->appends(Request::except('page'))->render() !!}
                </div>
              </div>
            </div>
          </div>

          
          @include('admin.ticket.view_ticket')
          

        {{-- Jika data banner kosong --}}
        @else
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-7">
                <div class="card-body">
                  <h5 class="card-title text-primary">Belum ada masukan apapun! 😞</h5>
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
        @endif
      </div>
    </div>
  </div>
  {{-- Footer --}}
  @include('layouts.admin.footer')

  <div class="content-backdrop fade"></div>
</div>  

@endsection
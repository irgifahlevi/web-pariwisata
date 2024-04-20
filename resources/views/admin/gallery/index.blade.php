@extends('layouts.admin.template_master_admin')
@section('content')
@include('admin.gallery.search')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kelola Destinasi /</span> Gallery</h4>
    <div class="row justify-content-center">
      <div class="col-md-12">

        {{-- Jika jumlah data banner lebih dari 0 --}}
        @if (count($gallery) > 0)

          <div class="mb-3">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" id="tambah-gallery" >
              Tambah gallery
            </button>

            <!-- Modal tambah data -->
            @include('admin.gallery.tambah_gallery')
          </div>

          {{-- Tabel --}}
          <div class="card">
            <h5 class="card-header">Data gallery</h5>
            <div class="card-body">
              <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Title</th>
                      <th>Nama destinasi</th>
                      <th>Deskripsi</th>
                      <th>Gambar</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $nomor = 1 + (($gallery->currentPage() - 1) * $gallery->perPage());
                    @endphp
                    @foreach($gallery as $item)
                    <tr>
                      <td>{{$nomor++}}</td>
                      <td><span class="d-inline-block text-truncate" style="max-width: 164px;">{{ $item->title }}</span></td>
                      <td><span class="d-inline-block text-truncate" style="max-width: 164px;">{{ $item->destinationGallery->destination_name }}</span></td>
                      <td><span class="d-inline-block text-truncate" style="max-width: 164px;">{{ $item->descriptions }}</span></td>
                      <td>
                        <div class="align-items-center">
                          <img src="{{ asset('storage/gallery/' . $item->image_gallery) }}" alt="{{ $item->image_gallery }}" class="w-px-50 h-auto" />
                        </div>
                      </td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <button class="dropdown-item" type="button" id="view-gallery" data-id="{{$item->id}}">
                              <i class="bx bx bxs-show me-1"></i>
                              View
                            </button>
                            <button class="dropdown-item" type="button" id="edit-gallery" data-id="{{$item->id}}">
                              <i class="bx bx-edit-alt me-1"></i> 
                              Edit
                            </button>
                            <button class="dropdown-item" type="button" id="hapus-gallery" data-id="{{$item->id}}">
                              <i class="bx bx-trash me-1"></i> 
                              Delete
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
                  {!! $gallery->appends(Request::except('page'))->render() !!}
                </div>
              </div>
            </div>
          </div>

          {{-- Modal edit data --}}
          @include('admin.gallery.update_gallery')
          @include('admin.gallery.view_gallery')
          

        {{-- Jika data banner kosong --}}
        @else
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-7">
                <div class="card-body">
                  <h5 class="card-title text-primary">gallery data is still empty, add data now! 😞</h5>
                  <p class="mb-4">
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ab at incidunt quidem vitae consectetur laboriosam! Nobis, aspernatur deleniti, perspiciatis consequatur rerum reprehenderit voluptatibus magnam sed facilis ut fuga exercitationem molestiae?
                  </p>
                  <button class="btn btn-sm btn-outline-primary" type="button" id="tambah-gallery">Add data now</button>
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
            <!-- Modal tambah -->
            @include('admin.gallery.tambah_gallery')
        @endif
      </div>
    </div>
  </div>
  {{-- Footer --}}
  @include('layouts.admin.footer')

  <div class="content-backdrop fade"></div>
</div>  

{{-- Untuk menghapus data --}}
<script>
  $('body').on('click', '#hapus-gallery', function(){
    var id = $(this).data('id');

    Swal.fire({
      customClass:{
        container: 'my-swal',
      },
      title: 'Apa anda yakin?',
      text: "ingin menghapus data gallery!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed){
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '{{route('gallery.destroy', ':id')}}'.replace(':id', id),
          type: 'DELETE',
          success: function(response) {
            if(response.status == 200){
              Swal.fire({
                customClass: {
                  container: 'my-swal',
                },
                title: 'Deleted!',
                text: `${response.message}`,
                icon: 'success'
              });

              // Reload halaman
              setTimeout(function(){
                location.reload();
              }, 600);
            }
          },
          error: function(response){
            if(response.status == 404){
              var res = response;
              Swal.fire({
              customClass: {
                container: 'my-swal',
              },
              title: `${res.statusText}`,
              text: `${res.responseJSON.message}`,
              icon: 'error'
          });
        }
      },
        });
      }
    });
  })
</script>
@endsection
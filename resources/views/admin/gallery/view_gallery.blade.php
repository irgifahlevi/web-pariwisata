<div class="modal fade" id="wiewGallery" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="card-body">
        <div id="loading-spinner" class="d-flex justify-content-center mt-3 mb-3">
          @include('layouts.admin.loading')
        </div>
        <div id="data-container">
          <h5 class="card-title"></h5>
          <h6 class="card-subtitle text-muted mb-4"></h6>
          <img id="images" class="img-fluid" src="" alt="Card image cap" />
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  $('body').on('click', `#view-gallery`, function () {
    const id = $(this).data('id'); // menangkap ID dari data attribute 'data-id'
    
    // tampilkan spinner
    $('#wiewGallery #loading-spinner').show();
    $('#wiewGallery #data-container').hide();

    $.ajax({
      url: `gallery/${id}/edit`,
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        if(response.status == 200) {
          let data = response.data;
          
          // sembunyikan spinner
          $('#wiewGallery #loading-spinner').hide();
          $('#wiewGallery #loading-spinner').addClass('d-none');
          
          // tampilkan data pada form
          $('#wiewGallery #data-container').show();
          // Isi data dalam elemen-elemen <h5> dan <h6>
          $('#wiewGallery .card-title').text(data.destination_gallery.destination_name);
          $('#wiewGallery .card-subtitle').text(data.descriptions);
          // Buat URL gambar dengan asset
          var imageUrl = "{{ asset('storage/gallery/') }}" + '/' + data.image_gallery;
          $('#wiewGallery #images').attr('src', imageUrl);
        }
      },
      error: function(response)
      {
        if(response.status == 404){
          var res = response;
          console.log(res);
          Swal.fire({
            customClass: {
              container: 'my-swal',
            },
            title: `${res.statusText}`,
            text: `${res.responseJSON.message}`,
            icon: 'error'
          });

          $('#wiewGallery').modal('hide');
          $('#wiewGallery #loading-spinner').removeClass('d-none');
        }
      },
    });

    $('#wiewGallery').modal('show');
    $('#wiewGallery #loading-spinner').removeClass('d-none');
  });
</script>
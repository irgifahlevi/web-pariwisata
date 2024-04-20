<div class="modal fade" id="wiewSlider" tabindex="-1" aria-hidden="true">
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

  $('body').on('click', `#view-slider`, function () {
    const id = $(this).data('id'); // menangkap ID dari data attribute 'data-id'

    // kosongkan form
    $('#edit-form-slider')[0].reset();
    
    // tampilkan spinner
    $('#wiewSlider #loading-spinner').show();
    $('#wiewSlider #data-container').hide();

    $.ajax({
      url: `slider/${id}/edit`,
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        if(response.status == 200) {
          let data = response.data;
          
          // sembunyikan spinner
          $('#wiewSlider #loading-spinner').hide();
          $('#wiewSlider #loading-spinner').addClass('d-none');
          
          // tampilkan data pada form
          $('#wiewSlider #data-container').show();
          // Isi data dalam elemen-elemen <h5> dan <h6>
          $('#wiewSlider .card-title').text(data.title);
          $('#wiewSlider .card-subtitle').text(data.description);
          // Buat URL gambar dengan asset
          var imageUrl = "{{ asset('storage/slider/') }}" + '/' + data.image_slider;
          $('#wiewSlider #images').attr('src', imageUrl);
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

          $('#wiewSlider').modal('hide');
          $('#wiewSlider #loading-spinner').removeClass('d-none');
        }
      },
    });

    $('#wiewSlider').modal('show');
    $('#wiewSlider #loading-spinner').removeClass('d-none');
  });
</script>
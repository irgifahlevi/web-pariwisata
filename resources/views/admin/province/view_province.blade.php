<div class="modal fade" id="wiewProvince" tabindex="-1" aria-hidden="true">
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

  $('body').on('click', `#view-province`, function () {
    const id = $(this).data('id'); // menangkap ID dari data attribute 'data-id'

    // kosongkan form
    $('#edit-form-province')[0].reset();
    
    // tampilkan spinner
    $('#wiewProvince #loading-spinner').show();
    $('#wiewProvince #data-container').hide();

    $.ajax({
      url: `province/${id}/edit`,
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        if(response.status == 200) {
          let data = response.data;
          
          // sembunyikan spinner
          $('#wiewProvince #loading-spinner').hide();
          $('#wiewProvince #loading-spinner').addClass('d-none');
          
          // tampilkan data pada form
          $('#wiewProvince #data-container').show();
          // Isi data dalam elemen-elemen <h5> dan <h6>
          $('#wiewProvince .card-title').text(data.province_name);
          $('#wiewProvince .card-subtitle').text(data.descriptions);
          // Buat URL gambar dengan asset
          var imageUrl = "{{ asset('storage/province/') }}" + '/' + data.image_province;
          $('#wiewProvince #images').attr('src', imageUrl);
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

          $('#wiewProvince').modal('hide');
          $('#wiewProvince #loading-spinner').removeClass('d-none');
        }
      },
    });

    $('#wiewProvince').modal('show');
    $('#wiewProvince #loading-spinner').removeClass('d-none');
  });
</script>
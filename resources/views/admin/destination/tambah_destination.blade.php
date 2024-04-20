<div class="modal fade" id="add-destination" tabindex="-1" role="dialog" aria-labelledby="modal-add-destination" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">Tambah destinasi</h5>
        <button type="button" class="btn-close close-modal-tambah" data-bs-dismiss="modal" aria-label="Close" ></button>
      </div>
      <div id="loading-spinner" class="d-flex justify-content-center mt-3 mb-5">
        @include('layouts.admin.loading')
      </div>
      <div id="data-container">
        <form id="form-destination" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row g-2">
              <div class="col mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="title"/>
                <small class="text-danger mt-2 error-message" id="title-error"></small>
              </div>
              <div class="col mb-3">
                <label class="form-label">Provinsi<span class="text-danger">*</span></label>
                <select class="form-select" name="province_id" id="province_id">
                  <option value="">Pilih provinsi</option>
                </select>
                <small class="text-danger mt-2 error-message" id="province_id-error"></small>
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-3">
                <label class="form-label">Nama destinasi<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="destination_name" id="destination_name"/>
                <small class="text-danger mt-2 error-message" id="destination_name-error"></small>
              </div>
              <div class="col mb-3">
                <label class="form-label">Foto<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="file" class="form-control" name="image_destination" id="image_destination" />
                  <label class="input-group-text">Upload</label>
                </div>
                <small class="text-danger mt-2 error-message" id="image_destination-error"></small>
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-3">
                <label class="form-label">Rating<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="rating" id="rating"/>
                <small class="text-danger mt-2 error-message" id="rating-error"></small>
              </div>
              <div class="col mb-3">
                <label class="form-label">Url Lokasi<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="url_locations" id="url_locations"/>
                <small class="text-danger mt-2 error-message" id="url_locations-error"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Deskripsi<span class="text-danger">*</span></label>
                <textarea class="form-control" name="descriptions" id="descriptions"></textarea>
                <small class="text-danger mt-2 error-message" id="descriptions-error"></small>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@section('scripts')
    <script>
      $('body').on('click', '#tambah-destination', function () {

        // tampilkan spinner
        $('#add-destination #loading-spinner').show();
        $('#add-destination #data-container').hide();

        $.ajax({
          url: '{{route('get.province')}}',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            // console.log(response);
            if(response.status == 200) {
              var provinceOptions = '<option value="">Pilih provinsi</option>';
              $.each(response.data, function(index, prov) {
                provinceOptions += '<option value="' + prov.id + '">' + prov.province_name + '</option>';
              });

              // sembunyikan spinner
              $('#add-destination #loading-spinner').hide();
              $('#add-destination #loading-spinner').addClass('d-none');
              
              // tampilkan data pada form
              $('#add-destination #data-container').show();

              $('#province_id').html(provinceOptions);

              //open modal
              $('#add-destination').modal('show');
            }
          }
        });
        
      });

      // Simpan data
      $(document).ready(function(){
        $('#form-destination').on('submit', function(e){
          e.preventDefault();
          // console.log('test');

          $('#title').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
            if ($(this).val() !== '' || inputVal.length <= maxLength) {
              $('#title-error').text('');
            }
          });

          $('#province_id').on('change', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
            if ($(this).val() !== '' || inputVal.length <= maxLength) {
              $('#province_id-error').text('');
            }
          });

          $('#destination_name').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
            if ($(this).val() !== '' || inputVal.length <= maxLength) {
              $('#destination_name-error').text('');
            }
          });

          $('#image_destination').on('change', function(){
            if($(this).val() !== ''){
              $('#image_destination-error').text('');
            }
          });
          
          $('#rating').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 500;
              if ($(this).val() !== '' || inputVal.length <= maxLength) {
                  $('#rating-error').text('');
              }
          });

          $('#url_locations').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
            if ($(this).val() !== '' || inputVal.length <= maxLength) {
              $('#url_locations-error').text('');
            }
          });

          $('#descriptions').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 500;
              if ($(this).val() !== '' || inputVal.length <= maxLength) {
                  $('#descriptions-error').text('');
              }
          });


          var formData = new FormData(this);

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          // for (let data of formData.entries()) {
          //   console.log(data[0] + ': ' + data[1]);
          // }

          $.ajax({
            type: 'POST',
            url: '{{route('destination.store')}}',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response)
            {
                if(response.status == 200){

                  Swal.fire({
                    customClass: {
                      container: 'my-swal',
                    },
                    title: 'Created!',
                    text: `${response.message}`,
                    icon: 'success'
                  });
                  
                  // Tutup modal add banner dan kosongkan form
                  $('#add-destination').modal('hide');
                  $('#form-destination')[0].reset();

                  // Reload halaman
                  setTimeout(function(){
                    location.reload();
                  }, 600)
                }
            },
            error: function(response)
            {
              if(response.status == 400){
                  let errors = response.responseJSON.errors;
                  for (let key in errors) {
                    let errorMessage = errors[key].join(', ');
                    $('#' + key + '-error').text(errorMessage);
                  }
              }
              if(response.status == 500){
                var res = response;
                Swal.fire({
                  customClass: {
                    container: 'my-swal',
                  },
                  title: `${res.statusText}`,
                  text: `${res.responseJSON.message}`,
                  icon: 'error'
                });
                // Tutup modal add banner dan kosongkan form
                $('#add-destination').modal('hide');
                $('#form-destination')[0].reset();
              }
            },
          })
        });
      });

      // untuk menghapus pesan error ketika mmodal tertutup dan menghapus form
      $(document).ready(function () {
        // Menambahkan event listener pada tombol close
        $('.close-modal-tambah').on('click', function (e) {
          $('.error-message').text(''); // Menghapus pesan error
          $('#form-destination')[0].reset(); // Mereset form
        });
        
        // Menambahkan event listener pada modal
        $('#add-destination').on('hidden.bs.modal', function (e) {
          $('.error-message').text(''); // Menghapus pesan error
          $('#form-destination')[0].reset(); // Mereset form
        });
      });
    </script>
@endsection

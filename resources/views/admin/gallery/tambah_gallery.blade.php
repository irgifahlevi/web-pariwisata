<div class="modal fade" id="add-gallery" tabindex="-1" role="dialog" aria-labelledby="modal-add-gallery" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">Tambah gallery</h5>
        <button type="button" class="btn-close close-modal-tambah" data-bs-dismiss="modal" aria-label="Close" ></button>
      </div>
      <div id="loading-spinner" class="d-flex justify-content-center mt-3 mb-5">
        @include('layouts.admin.loading')
      </div>
      <div id="data-container">
        <form id="form-gallery" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Title</span></label>
                <input type="text" class="form-control" name="title" id="title"/>
                <small class="text-danger mt-2 error-message" id="title-error"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Tempat destinasi<span class="text-danger">*</span></label>
                <select class="form-select" name="destination_id" id="destination_id">
                  <option value="">Pilih destinasi</option>
                </select>
                <small class="text-danger mt-2 error-message" id="destination_id-error"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Foto<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="file" class="form-control" name="image_gallery" id="image_gallery" />
                  <label class="input-group-text">Upload</label>
                </div>
                <small class="text-danger mt-2 error-message" id="image_gallery-error"></small>
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
      $('body').on('click', '#tambah-gallery', function () {

        // tampilkan spinner
        $('#add-gallery #loading-spinner').show();
        $('#add-gallery #data-container').hide();

        $.ajax({
          url: '{{route('get.destination')}}',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            // console.log(response);
            if(response.status == 200) {
              var destinationOptions = '<option value="">Pilih destinasi</option>';
              $.each(response.data, function(index, dest) {
                destinationOptions += '<option value="' + dest.id + '">' + dest.destination_name + '</option>';
              });

              // sembunyikan spinner
              $('#add-gallery #loading-spinner').hide();
              $('#add-gallery #loading-spinner').addClass('d-none');
              
              // tampilkan data pada form
              $('#add-gallery #data-container').show();

              $('#destination_id').html(destinationOptions);

              //open modal
              $('#add-gallery').modal('show');
            }
          }
        });
        
      });

      // Simpan data
      $(document).ready(function(){
        $('#form-gallery').on('submit', function(e){
          e.preventDefault();
          // console.log('test');

          $('#title').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
            if ($(this).val() !== '' || inputVal.length <= maxLength) {
              $('#title-error').text('');
            }
          });

          $('#destination_id').on('change', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
            if ($(this).val() !== '' || inputVal.length <= maxLength) {
              $('#destination_id-error').text('');
            }
          });

          $('#image_gallery').on('change', function(){
            if($(this).val() !== ''){
              $('#image_gallery-error').text('');
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
            url: '{{route('gallery.store')}}',
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
                  $('#add-gallery').modal('hide');
                  $('#form-gallery')[0].reset();

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
                $('#add-gallery').modal('hide');
                $('#form-gallery')[0].reset();
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
          $('#form-gallery')[0].reset(); // Mereset form
        });
        
        // Menambahkan event listener pada modal
        $('#add-gallery').on('hidden.bs.modal', function (e) {
          $('.error-message').text(''); // Menghapus pesan error
          $('#form-gallery')[0].reset(); // Mereset form
        });
      });
    </script>
@endsection

<div class="modal fade" id="add-guide" tabindex="-1" role="dialog" aria-labelledby="modal-add-guide" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">Tambah guide</h5>
        <button type="button" class="btn-close close-modal-tambah" data-bs-dismiss="modal" aria-label="Close" ></button>
      </div>
      <form id="form-guide" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label class="form-label">Title guide<span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="title" id="title"/>
              <small class="text-danger mt-2 error-message" id="title-error"></small>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label class="form-label">Nama guide<span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="guide_name" id="guide_name"/>
              <small class="text-danger mt-2 error-message" id="guide_name-error"></small>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label class="form-label">description</label>
              <textarea class="form-control" name="descriptions" id="descriptions"></textarea>
              <small class="text-danger mt-2 error-message" id="descriptions-error"></small>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label class="form-label">Foto<span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="file" class="form-control" name="image_guide" id="image_guide" />
                <label class="input-group-text">Upload</label>
              </div>
              <small class="text-danger mt-2 error-message" id="image_guide-error"></small>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label class="form-label">Url Instagram</label>
              <input type="text" class="form-control" name="url_instagram" id="url_instagram"/>
              <small class="text-danger mt-2 error-message" id="url_instagram-error"></small>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label class="form-label">Url facebook</label>
              <input type="text" class="form-control" name="url_facebook" id="url_facebook"/>
              <small class="text-danger mt-2 error-message" id="url_facebook-error"></small>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label class="form-label">Url whatsapp</label>
              <input type="text" class="form-control" name="url_whatsapp" id="url_whatsapp"/>
              <small class="text-danger mt-2 error-message" id="url_whatsapp-error"></small>
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


@section('scripts')
    <script>
      $('body').on('click', '#tambah-guide', function () {
        //open modal
        $('#add-guide').modal('show');
      });

      // Simpan data
      $(document).ready(function(){
        $('#form-guide').on('submit', function(e){
          e.preventDefault();
          // console.log('test');

          $('#title').on('input', function() {
            if ($(this).val() !== '') {
              $('#title-error').text('');
            }
          });
          $('#title').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
              if (inputVal.length <= maxLength) {
                  $('#title-error').text('');
              }
          });
          $('#guide_name').on('input', function() {
            if ($(this).val() !== '') {
              $('#guide_name-error').text('');
            }
          });
          $('#guide_name').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
              if (inputVal.length <= maxLength) {
                  $('#guide_name-error').text('');
              }
          });
          $('#descriptions').on('input', function() {
              if ($(this).val() !== '') {
                  $('#descriptions-error').text('');
              }
          });
          $('#descriptions').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 500;
              if (inputVal.length <= maxLength) {
                  $('#description-error').text('');
              }
          });

          $('#image_guide').on('change', function(){
            if($(this).val() !== ''){
              $('#image_guide-error').text('');
            }
          });

          $('#url_instagram').on('input', function() {
            if ($(this).val() !== '') {
              $('#url_instagram-error').text('');
            }
          });
          $('#url_instagram').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
              if (inputVal.length <= maxLength) {
                  $('#url_instagram-error').text('');
              }
          });

          $('#url_facebook').on('input', function() {
            if ($(this).val() !== '') {
              $('#url_facebook-error').text('');
            }
          });
          $('#url_facebook').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
              if (inputVal.length <= maxLength) {
                  $('#url_facebook-error').text('');
              }
          });
          
          $('#url_whatsapp').on('input', function() {
            if ($(this).val() !== '') {
              $('#url_whatsapp-error').text('');
            }
          });
          $('#url_whatsapp').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
              if (inputVal.length <= maxLength) {
                  $('#url_whatsapp-error').text('');
              }
          });
          
          var formData = new FormData(this);

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          for (let data of formData.entries()) {
            console.log(data[0] + ': ' + data[1]);
          }

          $.ajax({
            type: 'POST',
            url: '{{route('guide.store')}}',
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
                  $('#add-guide').modal('hide');
                  $('#form-guide')[0].reset();

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
            },
          })
        });
      });

      // untuk menghapus pesan error ketika mmodal tertutup dan menghapus form
      $(document).ready(function () {
        // Menambahkan event listener pada tombol close
        $('.close-modal-tambah').on('click', function (e) {
          $('.error-message').text(''); // Menghapus pesan error
          $('#form-guide')[0].reset(); // Mereset form
        });
        
        // Menambahkan event listener pada modal
        $('#add-guide').on('hidden.bs.modal', function (e) {
          $('.error-message').text(''); // Menghapus pesan error
          $('#form-guide')[0].reset(); // Mereset form
        });
      });
    </script>
@endsection

<div class="modal fade" id="editGuide" tabindex="-1" role="dialog" aria-labelledby="modalEditGuide" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title me-2" id="modalCenterTitle">Edit guide</h5>
        <button type="button" class="btn-close close-edit-guide" data-bs-dismiss="modal" aria-label="Close" ></button>
      </div>
      <div id="loading-spinner" class="d-flex justify-content-center mt-3 mb-5">
        @include('layouts.admin.loading')
      </div>
      <div id="data-container">
        <form id="edit-form-guide" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id" class="form-control" id="id">
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Title guide<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" id="titles"/>
                <small class="text-danger mt-2 error-messages" id="title-errors"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Nama guide<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="guide_name" id="guide_names"/>
                <small class="text-danger mt-2 error-messages" id="guide_name-errors"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="descriptions" id="descriptionss"></textarea>
                <small class="text-danger mt-2 error-messages" id="descriptions-errors"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Foto<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="file" class="form-control" name="image_guide" id="image_guides" />
                  <label class="input-group-text">Upload</label>
                </div>
                <small class="text-danger mt-2 error-messages" id="image_guide-errors"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Url Instagram</label>
                <input type="text" class="form-control" name="url_instagram" id="url_instagrams"/>
                <small class="text-danger mt-2 error-messages" id="url_instagram-errors"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Url facebook</label>
                <input type="text" class="form-control" name="url_facebook" id="url_facebooks"/>
                <small class="text-danger mt-2 error-messages" id="url_facebook-errors"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Url whatsapp</label>
                <input type="text" class="form-control" name="url_whatsapp" id="url_whatsapps"/>
                <small class="text-danger mt-2 error-messages" id="url_whatsapp-errors"></small>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>

  $('body').on('click', `#edit-guide`, function () {
    const id = $(this).data('id'); // menangkap ID dari data attribute 'data-id'

    // kosongkan form
    $('#edit-form-guide')[0].reset();
    
    // tampilkan spinner
    $('#editGuide #loading-spinner').show();
    $('#editGuide #data-container').hide();

    $.ajax({
      url: `guide/${id}/edit`,
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        if(response.status == 200) {
          let data = response.data;
          
          // sembunyikan spinner
          $('#editGuide #loading-spinner').hide();
          $('#editGuide #loading-spinner').addClass('d-none');
          
          // tampilkan data pada form
          $('#editGuide #data-container').show();

          $('#editGuide').find('input[name="id"]').val(data.id);
          $('#editGuide').find('input[name="title"]').val(data.title);
          $('#editGuide').find('input[name="guide_name"]').val(data.guide_name);
          $('#editGuide').find('textarea[name="descriptions"]').val(data.descriptions);
          $('#editGuide').find('input[name="url_instagram"]').val(data.url_instagram);
          $('#editGuide').find('input[name="url_facebook"]').val(data.url_facebook);
          $('#editGuide').find('input[name="url_whatsapp"]').val(data.url_whatsapp);
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

          $('#editGuide').modal('hide');
          $('#editGuide #loading-spinner').removeClass('d-none');
        }
      },
    });

    $('#editGuide').modal('show');
    $('#editGuide #loading-spinner').removeClass('d-none');
  });

  $(document).ready(function(){
    $('#edit-form-guide').on('submit', function(e){
      e.preventDefault();
      // console.log('test');
      const id = $('#editGuide').find('input[name="id"]').val();
      const title = $('#editGuide').find('input[name="title"]').val();
      const guide_name = $('#editGuide').find('input[name="guide_name"]').val();
      const descriptions = $('#editGuide').find('textarea[name="descriptions"]').val();
      const image_guide = $('#editGuide').find('input[name="image_guide"]')[0].files[0];
      const url_instagram = $('#editGuide').find('input[name="url_instagram"]').val();
      const url_facebook = $('#editGuide').find('input[name="url_facebook"]').val();
      const url_whatsapp = $('#editGuide').find('input[name="url_whatsapp"]').val();

      const formData = new FormData();

      formData.append('_method', 'PUT'); // formData gak fungsi di method PUT
      formData.append('title', title);
      formData.append('guide_name', guide_name);
      formData.append('descriptions', descriptions);

      if(image_guide !== undefined){
        formData.append('image_guide', image_guide);
      }
      
      formData.append('url_instagram', url_instagram);
      formData.append('url_facebook', url_facebook);
      formData.append('url_whatsapp', url_whatsapp);
      // console.log(formData);

      $('#titles').on('input', function() {
        if ($(this).val() !== '') {
          $('#title-errors').text('');
        }
      });
      $('#titles').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
          if (inputVal.length <= maxLength) {
            $('#title-errors').text('');
          }
      });
      $('#guide_names').on('input', function() {
        if ($(this).val() !== '') {
          $('#guide_name-errors').text('');
        }
      });
      $('#guide_names').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
          if (inputVal.length <= maxLength) {
            $('#guide_name-errors').text('');
          }
      });
      $('#descriptionss').on('input', function() {
          if ($(this).val() !== '') {
              $('#descriptions-errors').text('');
          }
      });
      $('#descriptionss').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 500;
          if (inputVal.length <= maxLength) {
              $('#descriptions-errors').text('');
          }
      });
      $('#image_guides').on('change', function(){
        if($(this).val() !== ''){
          $('#image_guide-errors').text('');
        }
      });

      $('#url_instagrams').on('input', function() {
        if ($(this).val() !== '') {
          $('#url_instagram-errors').text('');
        }
      });
      $('#url_instagrams').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
          if (inputVal.length <= maxLength) {
            $('#url_instagram-errors').text('');
          }
      });

      $('#url_facebooks').on('input', function() {
        if ($(this).val() !== '') {
          $('#url_facebook-errors').text('');
        }
      });
      $('#url_facebooks').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
          if (inputVal.length <= maxLength) {
            $('#url_facebook-errors').text('');
          }
      });
          
      $('#url_whatsapps').on('input', function() {
        if ($(this).val() !== '') {
          $('#url_whatsapp-errors').text('');
        }
      });
      $('#url_whatsapps').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
          if (inputVal.length <= maxLength) {
            $('#url_whatsapp-errors').text('');
          }
      });
      


      // for (let data of formData.entries()) {
      //   console.log(data[0] + ': ' + data[1]);
      // }
      

      $.ajax({
        url: '{{ route('guide.update', ':id') }}'.replace(':id', id),
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response){
          if(response.status == 200){
              Swal.fire({
                customClass: {
                  container: 'my-swal',
                },
                title: 'Updated!',
                text: `${response.message}`,
                icon: 'success'
              });

              // Tutup modal edit banner dan reset form
              $('#editGuide').modal('hide');
              $('#edit-form-guide')[0].reset();

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
              $('#' + key + '-errors').text(errorMessage);
            }
          }
        },
      })

    });
  });




  // untuk menghapus pesan error ketika mmodal tertutup
  $(document).ready(function () {
    // Menambahkan event listener pada tombol close
    $('.close-edit-guide').on('click', function (e) {
      $('.error-messages').text('');
    });
    
    // Menambahkan event listener pada modal
    $('#editGuide').on('hidden.bs.modal', function (e) {
      $('.error-messages').text('');
    });
  });
</script>

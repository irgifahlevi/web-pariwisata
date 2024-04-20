<div class="modal fade" id="editAbout" tabindex="-1" role="dialog" aria-labelledby="modalEditAbout" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title me-2" id="modalCenterTitle">Edit about</h5>
        <button type="button" class="btn-close close-edit-about" data-bs-dismiss="modal" aria-label="Close" ></button>
      </div>
      <div id="loading-spinner" class="d-flex justify-content-center mt-3 mb-5">
        @include('layouts.admin.loading')
      </div>
      <div id="data-container">
        <form id="edit-form-about" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id" class="form-control" id="id">
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Title about</label>
                <input type="text" class="form-control" name="title" id="titles"/>
                <small class="text-danger mt-2 error-messages" id="title-errors"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">description</label>
                <textarea class="form-control" name="description" id="descriptions"></textarea>
                <small class="text-danger mt-2 error-messages" id="description-errors"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Foto<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="file" class="form-control" name="image_about" id="image_abouts" />
                  <label class="input-group-text">Upload</label>
                </div>
                <small class="text-danger mt-2 error-messages" id="image_about-errors"></small>
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

  $('body').on('click', `#edit-about`, function () {
    const id = $(this).data('id'); // menangkap ID dari data attribute 'data-id'

    // kosongkan form
    $('#edit-form-about')[0].reset();
    
    // tampilkan spinner
    $('#editAbout #loading-spinner').show();
    $('#editAbout #data-container').hide();

    $.ajax({
      url: `about/${id}/edit`,
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        if(response.status == 200) {
          let data = response.data;
          
          // sembunyikan spinner
          $('#editAbout #loading-spinner').hide();
          $('#editAbout #loading-spinner').addClass('d-none');
          
          // tampilkan data pada form
          $('#editAbout #data-container').show();

          $('#editAbout').find('input[name="id"]').val(data.id);
          $('#editAbout').find('input[name="title"]').val(data.title);
          $('#editAbout').find('textarea[name="description"]').val(data.description);
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

          $('#editAbout').modal('hide');
          $('#editAbout #loading-spinner').removeClass('d-none');
        }
      },
    });

    $('#editAbout').modal('show');
    $('#editAbout #loading-spinner').removeClass('d-none');
  });

  $(document).ready(function(){
    $('#edit-form-about').on('submit', function(e){
      e.preventDefault();
      // console.log('test');
      const id = $('#editAbout').find('input[name="id"]').val();
      const title = $('#editAbout').find('input[name="title"]').val();
      const description = $('#editAbout').find('textarea[name="description"]').val();
      const image_about = $('#editAbout').find('input[name="image_about"]')[0].files[0];

      const formData = new FormData();

      formData.append('_method', 'PUT'); // formData gak fungsi di method PUT
      formData.append('title', title);
      formData.append('description', description);

      if(image_about !== undefined){
        formData.append('image_about', image_about);
      }
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
      $('#descriptions').on('input', function() {
          if ($(this).val() !== '') {
              $('#description-errors').text('');
          }
      });
      $('#descriptions').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 500;
          if (inputVal.length <= maxLength) {
              $('#description-errors').text('');
          }
      });
      $('#image_abouts').on('change', function(){
        if($(this).val() !== ''){
          $('#image_about-errors').text('');
        }
      });
      


      for (let data of formData.entries()) {
        console.log(data[0] + ': ' + data[1]);
      }
      

      $.ajax({
        url: '{{ route('about.update', ':id') }}'.replace(':id', id),
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
              $('#editAbout').modal('hide');
              $('#edit-form-about')[0].reset();

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
    $('.close-edit-about').on('click', function (e) {
      $('.error-messages').text('');
    });
    
    // Menambahkan event listener pada modal
    $('#editAbout').on('hidden.bs.modal', function (e) {
      $('.error-messages').text('');
    });
  });
</script>

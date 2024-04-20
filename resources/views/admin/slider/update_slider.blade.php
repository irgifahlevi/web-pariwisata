<div class="modal fade" id="editSlider" tabindex="-1" role="dialog" aria-labelledby="modalEditSlider" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title me-2" id="modalCenterTitle">Edit slider</h5>
        <button type="button" class="btn-close close-edit-slider" data-bs-dismiss="modal" aria-label="Close" ></button>
      </div>
      <div id="loading-spinner" class="d-flex justify-content-center mt-3 mb-5">
        @include('layouts.admin.loading')
      </div>
      <div id="data-container">
        <form id="edit-form-slider" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id" class="form-control" id="id">
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Title slider</label>
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
                  <input type="file" class="form-control" name="image_slider" id="image_sliders" />
                  <label class="input-group-text">Upload</label>
                </div>
                <small class="text-danger mt-2 error-messages" id="image_slider-errors"></small>
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

  $('body').on('click', `#edit-slider`, function () {
    const id = $(this).data('id'); // menangkap ID dari data attribute 'data-id'

    // kosongkan form
    $('#edit-form-slider')[0].reset();
    
    // tampilkan spinner
    $('#editSlider #loading-spinner').show();
    $('#editSlider #data-container').hide();

    $.ajax({
      url: `slider/${id}/edit`,
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        if(response.status == 200) {
          let data = response.data;
          
          // sembunyikan spinner
          $('#editSlider #loading-spinner').hide();
          $('#editSlider #loading-spinner').addClass('d-none');
          
          // tampilkan data pada form
          $('#editSlider #data-container').show();

          $('#editSlider').find('input[name="id"]').val(data.id);
          $('#editSlider').find('input[name="title"]').val(data.title);
          $('#editSlider').find('textarea[name="description"]').val(data.description);
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

          $('#editSlider').modal('hide');
          $('#editSlider #loading-spinner').removeClass('d-none');
        }
      },
    });

    $('#editSlider').modal('show');
    $('#editSlider #loading-spinner').removeClass('d-none');
  });

  $(document).ready(function(){
    $('#edit-form-slider').on('submit', function(e){
      e.preventDefault();
      // console.log('test');
      const id = $('#editSlider').find('input[name="id"]').val();
      const title = $('#editSlider').find('input[name="title"]').val();
      const description = $('#editSlider').find('textarea[name="description"]').val();
      const image_slider = $('#editSlider').find('input[name="image_slider"]')[0].files[0];

      const formData = new FormData();

      formData.append('_method', 'PUT'); // formData gak fungsi di method PUT
      formData.append('title', title);
      formData.append('description', description);

      if(image_slider !== undefined){
        formData.append('image_slider', image_slider);
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
      $('#image_sliders').on('change', function(){
        if($(this).val() !== ''){
          $('#image_slider-errors').text('');
        }
      });
      

      $.ajax({
        url: '{{ route('slider.update', ':id') }}'.replace(':id', id),
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
              $('#editSlider').modal('hide');
              $('#edit-form-slider')[0].reset();

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
    $('.close-edit-slider').on('click', function (e) {
      $('.error-messages').text('');
    });
    
    // Menambahkan event listener pada modal
    $('#editSlider').on('hidden.bs.modal', function (e) {
      $('.error-messages').text('');
    });
  });
</script>

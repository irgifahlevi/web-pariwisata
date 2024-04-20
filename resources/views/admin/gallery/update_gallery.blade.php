<div class="modal fade" id="editGallery" tabindex="-1" role="dialog" aria-labelledby="modalEditGallery" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title me-2" id="modalCenterTitle">Edit gallery</h5>
        <button type="button" class="btn-close close-edit-gallery" data-bs-dismiss="modal" aria-label="Close" ></button>
      </div>
      <div id="loading-spinner" class="d-flex justify-content-center mt-3 mb-5">
        @include('layouts.admin.loading')
      </div>
      <div id="data-container">
        <form id="edit-form-gallery" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id" class="form-control" id="id">
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Title</span></label>
                <input type="text" class="form-control" name="title" id="titles"/>
                <small class="text-danger mt-2 error-messages" id="title-errors"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Tempat destinasi</span></label>
                <select class="form-select" name="destination_id" id="destination_ids" disabled>
                  <option value="">Pilih destinasi</option>
                </select>
                <small class="text-danger mt-2 error-messages" id="destination_id-errors"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Foto<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="file" class="form-control" name="image_gallery" id="image_gallerys" />
                  <label class="input-group-text">Upload</label>
                </div>
                <small class="text-danger mt-2 error-messages" id="image_gallery-errors"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Deskripsi<span class="text-danger">*</span></label>
                <textarea class="form-control" name="descriptions" id="descriptionss"></textarea>
                <small class="text-danger mt-2 error-messages" id="descriptions-errors"></small>
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

  function getData(data){
    // Mengambil data destination
    $.ajax({
    url: '{{route('get.destination')}}',
    method: 'GET',
    dataType: 'json',
    success: function(response) {
      // console.log(response);
      if(response.status == 200){
        let destination = response.data;

        // Tambahkan opsi pada select cat
        $('#editGallery #destination_ids').html('');
        $('#editGallery #destination_ids').append(`<option value="">Pilih destinasi</option>`);
        destination.forEach(function(destination){
          let selected = '';
          if(destination.id == data.destination_id){
            selected = 'selected';
          }
          $('#editGallery #destination_ids').append(`<option value="${destination.id}" ${selected}>${destination.destination_name}</option>`);
        });

        // sembunyikan spinner
        $('#editGallery #loading-spinner').hide();
        $('#editGallery #loading-spinner').addClass('d-none');
          
        // tampilkan data pada form
        $('#editGallery #data-container').show();
      }
    },
    error: function(response){
      console.log(response);
    }
    });
  }

  $('body').on('click', `#edit-gallery`, function () {
    const id = $(this).data('id'); // menangkap ID dari data attribute 'data-id'

    // kosongkan form
    $('#edit-form-gallery')[0].reset();
    
    // tampilkan spinner
    $('#editGallery #loading-spinner').show();
    $('#editGallery #data-container').hide();

    $.ajax({
      url: `gallery/${id}/edit`,
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        if(response.status == 200) {
          let data = response.data;
          getData(data);

          $('#editGallery').find('input[name="id"]').val(data.id);
          $('#editGallery').find('input[name="title"]').val(data.title);
          $('#editGallery').find('textarea[name="descriptions"]').val(data.descriptions);
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

          $('#editGallery').modal('hide');
          $('#editGallery #loading-spinner').removeClass('d-none');
        }
      },
    });

    $('#editGallery').modal('show');
    $('#editGallery #loading-spinner').removeClass('d-none');
  });

  $(document).ready(function(){
    $('#edit-form-gallery').on('submit', function(e){
      e.preventDefault();
      // console.log('test');
      const id = $('#editGallery').find('input[name="id"]').val();
      const title = $('#editGallery').find('input[name="title"]').val();
      const destination_id = $('#editGallery').find('select[name="destination_id"]').val();
      const image_gallery = $('#editGallery').find('input[name="image_gallery"]')[0].files[0];
      const descriptions = $('#editGallery').find('textarea[name="descriptions"]').val();
      

      const formData = new FormData();

      formData.append('_method', 'PUT'); // formData gak fungsi di method PUT
      formData.append('title', title);
      formData.append('destination_id', destination_id);
      if(image_gallery !== undefined){
        formData.append('image_gallery', image_gallery);
      }
      formData.append('descriptions', descriptions);

      // console.log(formData);

      $('#titles').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
        if ($(this).val() !== '' || inputVal.length <= maxLength) {
          $('#title-errors').text('');
        }
      });

      $('#destination_ids').on('change', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
        if ($(this).val() !== '' || inputVal.length <= maxLength) {
          $('#destination_id-errors').text('');
        }
      });

      $('#image_gallerys').on('change', function(){
        if($(this).val() !== ''){
          $('#image_gallery-errors').text('');
        }
      });

      $('#descriptionss').on('input', function() {
        const inputVal = $(this).val();
            const maxLength = 500;
              if ($(this).val() !== '' || inputVal.length <= maxLength) {
          $('#descriptions-errors').text('');
        }
      });
      


      // for (let data of formData.entries()) {
      //   console.log(data[0] + ': ' + data[1]);
      // }
      

      $.ajax({
        url: '{{ route('gallery.update', ':id') }}'.replace(':id', id),
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
              $('#editGallery').modal('hide');
              $('#edit-form-gallery')[0].reset();

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
    $('.close-edit-gallery').on('click', function (e) {
      $('.error-messages').text('');
    });
    
    // Menambahkan event listener pada modal
    $('#editGallery').on('hidden.bs.modal', function (e) {
      $('.error-messages').text('');
    });
  });
</script>

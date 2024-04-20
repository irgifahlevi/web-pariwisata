<div class="modal fade" id="editProvince" tabindex="-1" role="dialog" aria-labelledby="modalEditProvince" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title me-2" id="modalCenterTitle">Edit provinsi</h5>
        <button type="button" class="btn-close close-edit-province" data-bs-dismiss="modal" aria-label="Close" ></button>
      </div>
      <div id="loading-spinner" class="d-flex justify-content-center mt-3 mb-5">
        @include('layouts.admin.loading')
      </div>
      <div id="data-container">
        <form id="edit-form-province" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id" class="form-control" id="id">
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Nama provinsi</label>
                <input type="text" class="form-control" name="province_name" id="province_names"/>
                <small class="text-danger mt-2 error-messages" id="province_name-errors"></small>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="titles"/>
                <small class="text-danger mt-2 error-messages" id="title-errors"></small>
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
                <label class="form-label">Foto</label>
                <div class="input-group">
                  <input type="file" class="form-control" name="image_province" id="image_provinces" />
                  <label class="input-group-text">Upload</label>
                </div>
                <small class="text-danger mt-2 error-messages" id="image_province-errors"></small>
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

  $('body').on('click', `#edit-province`, function () {
    const id = $(this).data('id'); // menangkap ID dari data attribute 'data-id'

    // kosongkan form
    $('#edit-form-province')[0].reset();
    
    // tampilkan spinner
    $('#editProvince #loading-spinner').show();
    $('#editProvince #data-container').hide();

    $.ajax({
      url: `province/${id}/edit`,
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        if(response.status == 200) {
          let data = response.data;
          
          // sembunyikan spinner
          $('#editProvince #loading-spinner').hide();
          $('#editProvince #loading-spinner').addClass('d-none');
          
          // tampilkan data pada form
          $('#editProvince #data-container').show();

          $('#editProvince').find('input[name="id"]').val(data.id);
          $('#editProvince').find('input[name="province_name"]').val(data.province_name);
          $('#editProvince').find('input[name="title"]').val(data.title);
          $('#editProvince').find('textarea[name="descriptions"]').val(data.descriptions);
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

          $('#editProvince').modal('hide');
          $('#editProvince #loading-spinner').removeClass('d-none');
        }
      },
    });

    $('#editProvince').modal('show');
    $('#editProvince #loading-spinner').removeClass('d-none');
  });

  $(document).ready(function(){
    $('#edit-form-province').on('submit', function(e){
      e.preventDefault();
      // console.log('test');
      const id = $('#editProvince').find('input[name="id"]').val();
      const province_name = $('#editProvince').find('input[name="province_name"]').val();
      const title = $('#editProvince').find('input[name="title"]').val();
      const descriptions = $('#editProvince').find('textarea[name="descriptions"]').val();
      const image_province = $('#editProvince').find('input[name="image_province"]')[0].files[0];

      const formData = new FormData();

      formData.append('_method', 'PUT'); // formData gak fungsi di method PUT
      formData.append('province_name', province_name);
      formData.append('title', title);
      formData.append('descriptions', descriptions);

      if(image_province !== undefined){
        formData.append('image_province', image_province);
      }
      // console.log(formData);

      $('#province_names').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
        if ($(this).val() !== '' || inputVal.length <= maxLength) {
          $('#province_name-errors').text('');
        }
      });

      $('#titles').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
        if ($(this).val() !== '' || inputVal.length <= maxLength) {
          $('#title-errors').text('');
        }
      });

      $('#descriptionss').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 500;
          if ($(this).val() !== '' || inputVal.length <= maxLength) {
              $('#descriptions-errors').text('');
          }
      });
      
      $('#image_provinces').on('change', function(){
        if($(this).val() !== ''){
          $('#image_province-errors').text('');
        }
      });
      

      // for (let data of formData.entries()) {
      //   console.log(data[0] + ': ' + data[1]);
      // }
      

      $.ajax({
        url: '{{ route('province.update', ':id') }}'.replace(':id', id),
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
              $('#editProvince').modal('hide');
              $('#edit-form-province')[0].reset();

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
    $('.close-edit-province').on('click', function (e) {
      $('.error-messages').text('');
    });
    
    // Menambahkan event listener pada modal
    $('#editProvince').on('hidden.bs.modal', function (e) {
      $('.error-messages').text('');
    });
  });
</script>

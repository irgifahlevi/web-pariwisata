<div class="modal fade" id="editDestination" tabindex="-1" role="dialog" aria-labelledby="modalEditDestination" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title me-2" id="modalCenterTitle">Edit destination</h5>
        <button type="button" class="btn-close close-edit-destination" data-bs-dismiss="modal" aria-label="Close" ></button>
      </div>
      <div id="loading-spinner" class="d-flex justify-content-center mt-3 mb-5">
        @include('layouts.admin.loading')
      </div>
      <div id="data-container">
        <form id="edit-form-destination" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id" class="form-control" id="id">
            <input type="hidden" name="id_detail" class="form-control" id="id_detail">
            <div class="row g-2">
              <div class="col mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="titles"/>
                <small class="text-danger mt-2 error-messages" id="title-errors"></small>
              </div>
              <div class="col mb-3">
                <label class="form-label">Provinsi<span class="text-danger">*</span></label>
                <select class="form-select" name="province_id" id="province_ids">
                  <option value="">Pilih provinsi</option>
                </select>
                <small class="text-danger mt-2 error-messages" id="province_id-errors"></small>
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-3">
                <label class="form-label">Nama destinasi<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="destination_name" id="destination_names"/>
                <small class="text-danger mt-2 error-messages" id="destination_name-errors"></small>
              </div>
              <div class="col mb-3">
                <label class="form-label">Foto<span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="file" class="form-control" name="image_destination" id="image_destinations" />
                  <label class="input-group-text">Upload</label>
                </div>
                <small class="text-danger mt-2 error-messages" id="image_destination-errors"></small>
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-3">
                <label class="form-label">Rating<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="rating" id="ratings"/>
                <small class="text-danger mt-2 error-messages" id="rating-errors"></small>
              </div>
              <div class="col mb-3">
                <label class="form-label">Url Lokasi<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="url_locations" id="url_locationss"/>
                <small class="text-danger mt-2 error-messages" id="url_locations-errors"></small>
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
    // Mengambil data province
    $.ajax({
    url: '{{route('get.province')}}',
    method: 'GET',
    dataType: 'json',
    success: function(response) {
      // console.log(response);
      if(response.status == 200){
        let province = response.data;

        // Tambahkan opsi pada select cat
        $('#editDestination #province_ids').html('');
        $('#editDestination #province_ids').append(`<option value="">Pilih provinsi</option>`);
        province.forEach(function(province){
          let selected = '';
          if(province.id == data.province_id){
            selected = 'selected';
          }
          $('#editDestination #province_ids').append(`<option value="${province.id}" ${selected}>${province.province_name}</option>`);
        });

        // sembunyikan spinner
        $('#editDestination #loading-spinner').hide();
        $('#editDestination #loading-spinner').addClass('d-none');
          
        // tampilkan data pada form
        $('#editDestination #data-container').show();
      }
    },
    error: function(response){
      console.log(response);
    }
    });
  }

  $('body').on('click', `#edit-destination`, function () {
    const id = $(this).data('id'); // menangkap ID dari data attribute 'data-id'

    // kosongkan form
    $('#edit-form-destination')[0].reset();
    
    // tampilkan spinner
    $('#editDestination #loading-spinner').show();
    $('#editDestination #data-container').hide();

    $.ajax({
      url: `destination/${id}/edit`,
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        if(response.status == 200) {
          let data = response.data;
          getData(data);

          $('#editDestination').find('input[name="id"]').val(data.id);
          $('#editDestination').find('input[name="id_detail"]').val(data.detail.id);
          $('#editDestination').find('input[name="title"]').val(data.title);
          $('#editDestination').find('input[name="destination_name"]').val(data.destination_name);
          $('#editDestination').find('input[name="rating"]').val(data.rating);
          $('#editDestination').find('input[name="url_locations"]').val(data.detail.url_locations);
          $('#editDestination').find('textarea[name="descriptions"]').val(data.detail.descriptions);
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

          $('#editDestination').modal('hide');
          $('#editDestination #loading-spinner').removeClass('d-none');
        }
      },
    });

    $('#editDestination').modal('show');
    $('#editDestination #loading-spinner').removeClass('d-none');
  });

  $(document).ready(function(){
    $('#edit-form-destination').on('submit', function(e){
      e.preventDefault();
      // console.log('test');
      const id = $('#editDestination').find('input[name="id"]').val();
      const id_detail = $('#editDestination').find('input[name="id_detail"]').val();
      const title = $('#editDestination').find('input[name="title"]').val();
      const province_id = $('#editDestination').find('select[name="province_id"]').val();
      const destination_name = $('#editDestination').find('input[name="destination_name"]').val();
      const image_destination = $('#editDestination').find('input[name="image_destination"]')[0].files[0];
      const rating = $('#editDestination').find('input[name="rating"]').val();
      const url_locations = $('#editDestination').find('input[name="url_locations"]').val();
      const descriptions = $('#editDestination').find('textarea[name="descriptions"]').val();
      

      const formData = new FormData();

      formData.append('_method', 'PUT'); // formData gak fungsi di method PUT
      formData.append('title', title);
      formData.append('province_id', province_id);
      formData.append('destination_name', destination_name);
      if(image_destination !== undefined){
        formData.append('image_destination', image_destination);
      }
      formData.append('rating', rating);
      formData.append('url_locations', url_locations);
      formData.append('descriptions', descriptions);
      formData.append('id_detail', id_detail);

      // console.log(formData);

      $('#titles').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
        if ($(this).val() !== '' || inputVal.length <= maxLength) {
          $('#title-errors').text('');
        }
      });

      $('#province_ids').on('change', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
        if ($(this).val() !== '' || inputVal.length <= maxLength) {
          $('#province_id-errors').text('');
        }
      });

      $('#destination_names').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
        if ($(this).val() !== '' || inputVal.length <= maxLength) {
          $('#destination_name-errors').text('');
        }
      });

      $('#image_destinations').on('change', function(){
        if($(this).val() !== ''){
          $('#image_destination-errors').text('');
        }
      });
          
      $('#ratings').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 500;
          if ($(this).val() !== '' || inputVal.length <= maxLength) {
            $('#rating-errors').text('');
          }
      });

      $('#url_locationss').on('input', function() {
        const inputVal = $(this).val();
        const maxLength = 255;
        if ($(this).val() !== '' || inputVal.length <= maxLength) {
          $('#url_locations-errors').text('');
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
        url: '{{ route('destination.update', ':id') }}'.replace(':id', id),
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
              $('#editDestination').modal('hide');
              $('#edit-form-destination')[0].reset();

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
    $('.close-edit-destination').on('click', function (e) {
      $('.error-messages').text('');
    });
    
    // Menambahkan event listener pada modal
    $('#editDestination').on('hidden.bs.modal', function (e) {
      $('.error-messages').text('');
    });
  });
</script>

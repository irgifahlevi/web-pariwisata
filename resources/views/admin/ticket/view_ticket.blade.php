<div class="modal fade" id="wiewTicket" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="card-body">
        <div id="loading-spinner" class="d-flex justify-content-center mt-3 mb-3">
          @include('layouts.admin.loading')
        </div>
        <div id="data-container">
          <h5 class="card-title mb-4"></h5>
          <h6 class="card-subtitle mb-2"></h6>
          <h6 class="card-text text-muted mb-2"></h6>
          <img id="images" class="img-fluid" src="" alt="Card image cap" />
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  $('body').on('click', `#view-ticket`, function () {
    const id = $(this).data('id'); // menangkap ID dari data attribute 'data-id'
    
    // tampilkan spinner
    $('#wiewTicket #loading-spinner').show();
    $('#wiewTicket #data-container').hide();

    $.ajax({
      url: `ticket/${id}/show`,
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        if(response.status == 200) {
          let data = response.data;
          
          // sembunyikan spinner
          $('#wiewTicket #loading-spinner').hide();
          $('#wiewTicket #loading-spinner').addClass('d-none');
          
          // tampilkan data pada form
          $('#wiewTicket #data-container').show();
          // Isi data dalam elemen-elemen <h5> dan <h6>
          var name = data.name;
          var email = data.email;
          var nameAndEmail = name + ' - ' + email;

          var desc = data.transaction_code;
          var time = data.created_at;
          var timeParts = time.split('T');
          var date = timeParts[0];

          var descAndDate = desc + '  Booking date : ' + date;


          $('#wiewTicket .card-title').text(data.destination_ticket.destination_name);
          $('#wiewTicket .card-subtitle').text(nameAndEmail);
          $('#wiewTicket .card-text').text(descAndDate);
          // Buat URL gambar dengan asset
          var imageUrl = "{{ asset('storage/destination/') }}" + '/' + data.destination_ticket.image_destination;
          $('#wiewTicket #images').attr('src', imageUrl);
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

          $('#wiewTicket').modal('hide');
          $('#wiewTicket #loading-spinner').removeClass('d-none');
        }
      },
    });

    $('#wiewTicket').modal('show');
    $('#wiewTicket #loading-spinner').removeClass('d-none');
  });
</script>
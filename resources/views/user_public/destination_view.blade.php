<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PARIWISATA - Website</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #loading-spinner {
            display: none;
        }
        .my-swal {
        z-index: 10000000; !important
    }
    </style>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('Template_public/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('Template_public/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('Template_public/css/style.css')}}" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid bg-light pt-3 d-none d-lg-block">
        <div class="container">
            <div class="row">
                
                {{-- header email --}}
                @include('user_public.template.header_email')
                
                <div class="col-lg-6 text-center text-lg-right">
                    <div class="d-inline-flex align-items-center">
                        <a class="text-primary px-3" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-primary px-3" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-primary px-3" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-primary px-3" href="">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="text-primary pl-3" href="">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="container-lg position-relative p-0 px-lg-3" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg bg-light navbar-light shadow-lg py-3 py-lg-0 pl-3 pl-lg-5">
                
                {{-- header brand --}}
                @include('user_public.template.header_brand')

                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <a href="{{route('public.index')}}" class="nav-item nav-link">Home</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="container-fluid page-header">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
                <h3 class="display-4 text-white text-uppercase">Destinasi Detail</h3>
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="/">Home</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Destinasi Detail</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Blog Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Blog Detail Start -->
                    <div class="pb-3">
                        <div class="blog-item">
                            <div class="position-relative">
                                <img class="img-fluid w-100" src="{{ asset('storage/destination/' . $destination->image_destination) }}" alt="">
                            </div>
                        </div>
                        <div class="bg-white mb-3 p-3">
                            <div id="destinationID" data-destination-id="{{ $destination->id }}"></div>
                            <div id="destinationName" data-destination-name="{{ $destination->destination_name }}"></div>

                          <div class="d-flex mb-3">
                              <a class="text-primary text-uppercase text-decoration-none" href="">{{ $destination->province->province_name }}</a>
                              <span class="text-primary px-2">|</span>
                              <a class="text-primary text-uppercase text-decoration-none" href="">INDONESIA</a>
                          </div>
                          <h2 class="mb-3">{{ $destination->destination_name }}</h2>
                          <p>{{ $destination->province->descriptions }}</p>
                          
                          <h4 class="mb-3">{{ $destination->title }}</h4>
                          <div class="bg-white img-container">
                              <img class="img-fluid w-100 mb-3" src="{{ asset('storage/province/' . $destination->province->image_province) }}">
                          </div>
                          <p>{{ $destination->detail->descriptions }}</p>        
                      </div>
                    </div>
                </div>
    
                <div class="col-lg-4 mt-5 mt-lg-0">

                    <!-- Maps -->
                    <div class="d-flex flex-column text-center bg-white mb-5 py-sm-1 px-1">
                      <div class="bg-white" style="padding: 10px;">
                          <h3 class="text-primary mb-2">Location</h3>
                          <p>View on google maps</p>
                          <div id="data_map" data-map-detail="{{ $destination->detail->url_locations }}"></div>
                          <div class="mapouter">
                              <div class="gmap_canvas" id="url_map">
                                 {{-- Embed frame --}}
                              </div>
                          </div>
                        </div>
                    </div>

                    <!-- Recent Post -->
                    <div class="mb-5">
                      <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Wisata Lainya</h4>
                        @foreach ($destinationAll as $item)
                            <a class="d-flex align-items-center text-decoration-none bg-white mb-3" href="{{ route('view.destination', ['id' => $item->id]) }}">
                                <img class="img-fluid" src="{{ asset('storage/destination/' . $item->image_destination) }}" alt="" style="max-width: 200px; height: auto;">
                                <div class="pl-3">
                                    <h6 class="m-1">{{ $item->destination_name }}</h6>
                                    <small>{{ $item->province->province_name }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="text-center mb-3 pb-3">
                    <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Galeri</h6>
                    <h1>Galeri Wisata {{$destination->destination_name}}</h1>
                </div>
                <div class="owl-carousel testimonial-carousel carousel-1">
                    @foreach ($gallery as $item)
                        <div class="pb-4">
                            <div class="blog-item">
                                <div class="position-relative">
                                    <img class="img-fluid w-100" src="{{ asset('storage/gallery/' . $item->image_gallery) }}" alt="{{ $item->image_gallery }}" alt="">
                                </div>
                                <div class="bg-white p-4">
                                    <div class="d-flex mb-2">
                                        <a class="text-primary text-uppercase text-decoration-none text-truncate" href="">{{ $item->destinationGallery->destination_name }}</a>
                                    </div>
                                    <a class="h5 m-0 text-decoration-none text-truncate" href="">{{ $item->title }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-registration py-5 mt-5" style="margin: 90px 0;" id="booking">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-5 mb-lg-0">
                    <div class="mb-4">
                        <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Mega Offer</h6>
                        <h1 class="text-white"><span class="text-primary">30% OFF</span> For Honeymoon</h1>
                    </div>
                    <p class="text-white">Invidunt lorem justo sanctus clita. Erat lorem labore ea, justo dolor lorem ipsum ut sed eos,
                        ipsum et dolor kasd sit ea justo. Erat justo sed sed diam. Ea et erat ut sed diam sea ipsum est
                        dolor</p>
                    <ul class="list-inline text-white m-0">
                        <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Labore eos amet dolor amet diam</li>
                        <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Etsea et sit dolor amet ipsum</li>
                        <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Diam dolor diam elitripsum vero.</li>
                    </ul>
                </div>
                <div class="col-lg-5">
                    <div class="card border-0">
                        <div class="card-header bg-primary text-center p-4">
                            <h1 class="text-white m-0">Pesan Tiket</h1>
                        </div>
                        <div class="card-body rounded-bottom bg-white p-5">
                            <form id="form-gallery" enctype="multipart/form-data">
                                <div class="form-group">
                                    <select class="custom-select px-4" style="height: 47px;" name="destination_id" id="destination_id" readonly>
                                        <option value="">Pilih destinasi</option>
                                    </select>
                                    <small class="text-danger mt-2 error-message" id="destination_id-error"></small>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control p-4" name="name" id="name" placeholder="Nama lengkap" />
                                    <small class="text-danger mt-2 error-message" id="name-error"></small>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control p-4" name="email" id="email" placeholder="Email" />
                                    <small class="text-danger mt-2 error-message" id="email-error"></small>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control p-4" name="capacity" id="capacity" placeholder="Kapasitas orang"/>
                                    <small class="text-danger mt-2 error-message" id="capacity-error"></small>
                                </div>
                                <div>
                                    <button class="btn btn-primary btn-block py-3" type="submit">Pesan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-5 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Saran</h6>
                <h1>Saran & Masukan Untuk Wisata {{$destination->destination_name}}</h1>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="bg-white mb-3" style="padding: 30px;">
                        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Masukan & Saran</h4>
                        <form id="send-suggestion" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="destination_id" value="{{ $destination->id }}">
                            </div>
                            <div class="form-group">
                                <label for="name">Nama *</label>
                                <input type="text" class="form-control" name="name" id="names">
                                <small class="text-danger mt-2 error-message" id="name-errors"></small>
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" class="form-control" name="email" id="emails">
                                <small class="text-danger mt-2 error-message" id="email-errors"></small>
                            </div>
                            <div class="form-group">
                                <label for="message">Saran *</label>
                                <textarea cols="30" rows="5" class="form-control" name="descriptions" id="descriptionss"></textarea>
                                <small class="text-danger mt-2 error-message" id="descriptions-errors"></small>
                            </div>
                            <div class="form-group mb-0">
                                <input type="submit"
                                    class="btn btn-primary font-weight-semi-bold py-2 px-3">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 mt-5 mt-lg-0">

                <!-- Recent Post -->
                    <div class="mb-5">
                        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Wisata Lainya</h4>
                            @foreach ($destinationAllAsc as $item)
                                <a class="d-flex align-items-center text-decoration-none bg-white mb-3" href="{{ route('view.destination', ['id' => $item->id]) }}">
                                    <img class="img-fluid" src="{{ asset('storage/destination/' . $item->image_destination) }}" alt="" style="max-width: 200px; height: auto;">
                                    <div class="pl-3">
                                        <h6 class="m-1">{{ $item->destination_name }}</h6>
                                        <small>{{ $item->province->province_name }}</small>
                                    </div>
                                </a>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- footer --}}
    @include('user_public.template.footer')


<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('Template_public/lib/easing/easing.min.js')}}"></script>
<script src="{{asset('Template_public/lib/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('Template_public/lib/tempusdominus/js/moment.min.js')}}"></script>
<script src="{{asset('Template_public/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
<script src="{{asset('Template_public/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<!-- Contact Javascript File -->
<script src="{{asset('Template_public/mail/jqBootstrapValidation.min.js')}}"></script>
<script src="{{asset('Template_public/mail/contact.js')}}"></script>

<!-- Template Javascript -->
<script src="{{asset('Template_public/js/main.js')}}"></script>
<script>
    $(document).ready(function() {
        // Mengambil map detail destination
        var mapDetail = $("#data_map").data("map-detail");

        // Mengambil elemen dengan ID "url_map"
        var urlMap = $("#url_map");

        // Anda dapat mengubah elemen "url_map" dengan data yang Anda ambil
        urlMap.html(mapDetail);

        // Sekarang data dari "mapDetail" telah dimasukkan ke dalam elemen "url_map"
    });
</script>


<script>
    $(document).ready(function() {
        // Mengambil data dari elemen <div>
        var destinationId = $("#destinationID").data("destination-id");
        var destinationName = $("#destinationName").data("destination-name");

        // Mengambil elemen <select>
        var select = $("#destination_id");

        if (destinationId && destinationName) {
            // Membuat opsi baru dengan ID dan nama destinasi
            var option = new Option(destinationName, destinationId, true, true);
            select.append(option);

            // Menonaktifkan opsi "Pilih destinasi"
            select.find('option[value=""]').prop('disabled', true);
        }
    });

    // Simpan data
    $(document).ready(function(){
        $('#form-gallery').on('submit', function(e){
            e.preventDefault();
            // console.log('test');

            $('#name').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
            if ($(this).val() !== '' || inputVal.length <= maxLength) {
                $('#name-error').text('');
            }
            });
            $('#email').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
            if ($(this).val() !== '' || inputVal.length <= maxLength) {
                $('#email-error').text('');
            }
            });
            $('#capacity').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
            if ($(this).val() !== '' || inputVal.length <= maxLength) {
                $('#capacity-error').text('');
            }
            });

            $('#destination_id').on('change', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
            if ($(this).val() !== '' || inputVal.length <= maxLength) {
                $('#destination_id-error').text('');
            }
            });

            var formData = new FormData(this);

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            // for (let data of formData.entries()) {
            //  console.log(data[0] + ': ' + data[1]);
            // }

            $.ajax({
            type: 'POST',
            url: '{{route('ticket.store')}}',
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
                    title: 'Sukses!',
                    text: `${response.message}`,
                    icon: 'success'
                    });
                    
                    // Tutup modal add banner dan kosongkan form
                    $('#add-gallery').modal('hide');
                    $('#form-gallery')[0].reset();

                    // Reload halaman
                    setTimeout(function(){
                    location.reload();
                    }, 1200)
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
                }
            },
            })
        });
    });
    $(document).ready(function(){
        $('#send-suggestion').on('submit', function(e){
            e.preventDefault();
            // console.log('test');

            $('#names').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
            if ($(this).val() !== '' || inputVal.length <= maxLength) {
                $('#name-errors').text('');
            }
            });
            $('#emails').on('input', function() {
            const inputVal = $(this).val();
            const maxLength = 255;
            if ($(this).val() !== '' || inputVal.length <= maxLength) {
                $('#email-errors').text('');
            }
            });
            $('#descriptionss').on('input', function() {
                const inputVal = $(this).val();
                const maxLength = 500;
                if ($(this).val() !== '' || inputVal.length <= maxLength) {
                    $('#descriptions-errors').text('');
                }
            });

            var formData = new FormData(this);

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            // for (let data of formData.entries()) {
            //  console.log(data[0] + ': ' + data[1]);
            // }

            $.ajax({
            type: 'POST',
            url: '{{route('suggestion.store')}}',
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
                    title: 'Sukses!',
                    text: `${response.message}`,
                    icon: 'success'
                    });
                    
                    // Tutup modal add banner dan kosongkan form
                    $('#add-gallery').modal('hide');
                    $('#form-gallery')[0].reset();

                    // Reload halaman
                    setTimeout(function(){
                    location.reload();
                    }, 1200)
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
                }
            },
            })
        });
    });
</script>
</body>

</html>
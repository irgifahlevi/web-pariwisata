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
                        <a href="{{route('public.index')}}" class="nav-item nav-link active">Home</a>
                        <a href="#about" class="nav-item nav-link">About</a>
                        <a href="#service" class="nav-item nav-link">Services</a>
                        <a href="#destination" class="nav-item nav-link">Destination</a>
                        <a href="#guide" class="nav-item nav-link">Guides</a>
                        <a href="#gallery" class="nav-item nav-link">Gallery</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{asset('Template_public/img/carousel-1.jpg')}}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase mb-md-3">Jelajah Indonesia</h4>
                            <h1 class="display-3 text-white mb-md-4">Nikmati Keindahan Alam Indonesia</h1>
                            <a href="#booking" id="pesan" class="btn btn-primary py-md-3 px-md-5 mt-2">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
                @foreach ($slider as $item)
                    <div class="carousel-item">
                        <img class="w-100" src="{{ asset('storage/slider/' . $item->image_slider) }}" alt="{{ $item->image_slider }}">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 900px;">
                                <h4 class="text-white text-uppercase mb-md-3">{{ $item->title }}</h4>
                                <h1 class="display-3 text-white mb-md-4">{{ $item->description }}</h1>
                                <a href="#booking" id="pesan" class="btn btn-primary py-md-3 px-md-5 mt-2">Pesan Sekarang</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                
            </div>
            <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                <div class="btn btn-dark" style="width: 45px; height: 45px;">
                    <span class="carousel-control-prev-icon mb-n2"></span>
                </div>
            </a>
            <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                <div class="btn btn-dark" style="width: 45px; height: 45px;">
                    <span class="carousel-control-next-icon mb-n2"></span>
                </div>
            </a>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Booking Start -->
    <div class="container-fluid booking mt-5 pb-5">
        <div class="container pb-5">
            <div class="bg-light shadow" style="padding: 30px;">
                <div class="row justify-content-center align-items-center" style="min-height: 60px;">
                    <div class="col-md-12"> <!-- Gunakan col-md-6 untuk membuat input dan tombol berada di tengah -->
                        <form method="GET" class="form-inline">
                            <div class="input-group w-100"> <!-- Gunakan w-100 untuk membuat input memenuhi panjang -->
                                <input type="text" class="form-control p-4" id="search" placeholder="Subject" value="{{$search_destination}}" name="search_destination"/>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    <!-- Booking End -->


    <!-- About Start -->
    <div class="container-fluid py-5"  id="about">
        <div class="container pt-5">
            <div class="row">
                <div class="col-lg-6" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        @foreach ($about as $item)               
                        <img class="position-absolute w-100 h-100" src="{{ asset('storage/about/' . $item->image_about) }}" style="object-fit: cover;">
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 pt-5 pb-lg-5">
                    <div class="about-text bg-white p-4 p-lg-5 my-lg-5">
                        <h1 class="mb-3">Keindahan pesona Indonesia yang membuatnya wajib dijelajahi</h1>
                        <p>Dengan bentangan gugusan pulau dari Sabang hingga Merauke, Indonesia memiliki keberagaman wisata alam, budaya, hingga kuliner yang menggoda. Ramah tamah warga lokal yang membuat wisatawan nyaman dan merasa di kampung halaman juga semakin indah ketika unsur adat istiadat tradisional yang masih autentik dikenalkan.</p>
                        <div class="row mb-4">
                            @foreach ($slider as $item)
                            <div class="col-6 mb-4">
                                <img class="img-fluid" src="{{ asset('storage/slider/' . $item->image_slider) }}" alt="">
                            </div>
                            @endforeach
                        </div>
                        <a href="#booking" id="pesan" class="btn btn-primary mt-1">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Feature Start -->
    <div class="container-fluid pb-5 pt-5">
        <div class="container pb-5">
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex mb-4 mb-lg-0">
                        <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-primary mr-3" style="height: 100px; width: 100px;">
                            <i class="fa fa-2x fa-money-check-alt text-white"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <h5 class="">Harga Kompetitif</h5>
                            <p class="m-0">Magna sit magna dolor duo dolor labore rebum amet elitr est diam sea</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex mb-4 mb-lg-0">
                        <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-primary mr-3" style="height: 100px; width: 100px;">
                            <i class="fa fa-2x fa-award text-white"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <h5 class="">Pelayanan Terbaik</h5>
                            <p class="m-0">Magna sit magna dolor duo dolor labore rebum amet elitr est diam sea</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex mb-4 mb-lg-0">
                        <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-primary mr-3" style="height: 100px; width: 100px;">
                            <i class="fa fa-2x fa-globe text-white"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <h5 class="">Layanan Se-indonesia</h5>
                            <p class="m-0">Magna sit magna dolor duo dolor labore rebum amet elitr est diam sea</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->


    <!-- Destination Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Destinasi Populer</h6>
                <h1>Jelajahi Berbagai Destinasi Indonesia</h1>
            </div>
            <div class="row">
                @foreach ($province as $item)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="destination-item position-relative overflow-hidden mb-2">
                            <img class="img-fluid" src="{{ asset('storage/province/' . $item->image_province) }}" alt="{{ asset('storage/province/' . $item->image_province) }}">
                            <a class="destination-overlay text-white text-decoration-none" href="">
                                <h5 class="text-white">{{ $item->province_name }}</h5>
                                <span>{{ $item->title }}</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Destination Start -->


    <!-- Service Start -->
    <div class="container-fluid py-5"  id="service">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Layanan</h6>
                <h1>Pelayanan Pariwisata</h1>
            </div>
            <div class="owl-carousel testimonial-carousel">
                <div class="text-center mb-4">
                    <div class="service-item bg-white text-center mb-2 py-5 px-4">
                        <i class="fa fa-2x fa-route mx-auto mb-4"></i>
                        <h5 class="mb-2">Pemandu Wisata</h5>
                        <p class="m-0">Justo sit justo eos amet tempor amet clita amet ipsum eos elitr. Amet lorem est amet labore</p>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <div class="service-item bg-white text-center mb-2 py-5 px-4">
                        <i class="fa fa-2x fa-ticket-alt mx-auto mb-4"></i>
                        <h5 class="mb-2">Pemesanan Tiket</h5>
                        <p class="m-0">Justo sit justo eos amet tempor amet clita amet ipsum eos elitr. Amet lorem est amet labore</p>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <div class="service-item bg-white text-center mb-2 py-5 px-4">
                        <i class="fa fa-2x fa-atlas mx-auto mb-4"></i>
                        <h5 class="mb-2">Panduan Perjalanan</h5>
                        <p class="m-0">Justo sit justo eos amet tempor amet clita amet ipsum eos elitr. Amet lorem est amet labore</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- Packages Start -->
    <div class="container-fluid py-5" id="destination">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Wisata & Rekreasi</h6>
                <h1>Tempat Populer Di Indonesia</h1>
            </div>
            <div class="row">
                @foreach ($destination as $item)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="package-item bg-white mb-2">
                            <img class="img-fluid" src="{{ asset('storage/destination/' . $item->image_destination) }}" alt="">
                            <div class="p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <small class="m-0"><i class="fa fa-map-marker-alt text-primary mr-2"></i>{{ $item->province->province_name }}</small>
                                    <small class="m-0"><i class="fa fa-calendar-alt text-primary mr-2"></i>3 days</small>
                                    <small class="m-0"><i class="fa fa-user text-primary mr-2"></i>2 Person</small>
                                </div>
                                <a class="h5 text-decoration-none" href="{{ route('view.destination', ['id' => $item->id]) }}">{{ $item->destination_name }}</a>
                                <div class="border-top mt-4 pt-4">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="m-0"><i class="fa fa-star text-primary mr-2"></i>{{ $item->rating }}<small> (100)</small></h6>
                                        <h5 class="m-0">$350</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Packages End -->


    <!-- Registration Start -->
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
                                    <select class="custom-select px-4" style="height: 47px;" name="destination_id" id="destination_id">
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
    <!-- Registration End -->


    <!-- Team Start -->
    <div class="container-fluid py-5" id="guide">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Pemandu</h6>
                <h1>Pemandu Tempat Wisata</h1>
            </div>
            <div class="row">
                @foreach ($guide as $item)
                    
                <div class="col-lg-3 col-md-4 col-sm-6 pb-2">
                    <div class="team-item bg-white mb-4">
                        <div class="team-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('storage/guide/' . $item->image_guide) }}" alt="">
                            <div class="team-social">
                                <a class="btn btn-outline-primary btn-square" href="{{ $item->url_instagram }}"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-outline-primary btn-square" href="{{ $item->url_facebook }}"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-primary btn-square" href="{{ $item->url_whatsapp }}"><i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <h5 class="text-truncate">{{ $item->guide_name }}</h5>
                            <p class="m-0">{{ $item->title }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Team End -->


    <!-- Testimonial Start -->
    <div class="container-fluid py-5"id="gallery">
        <div class="container py-5">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Galleri</h6>
                <h1>Foto Galleri Destinasi</h1>
            </div>
            <div class="owl-carousel testimonial-carousel carousel-1">
                @foreach ($gallery_asc as $item)
                <div class="pb-4">
                    <div class="blog-item">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ asset('storage/gallery/' . $item->image_gallery) }}" alt="{{ $item->image_gallery }}" alt="">
                        </div>
                        <div class="bg-white p-4">
                            <div class="d-flex mb-2">
                                <a class="text-primary text-uppercase text-decoration-none" href="{{ route('view.destination', ['id' => $item->destinationGallery->id]) }}">{{ $item->destinationGallery->destination_name }}</a>
                            </div>
                            <a class="h5 m-0 text-decoration-none">{{ $item->title }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="owl-carousel testimonial-carousel mt-4 carousel-2">
                @foreach ($gallery_desc as $item)
                <div class="pb-4">
                    <div class="blog-item">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ asset('storage/gallery/' . $item->image_gallery) }}" alt="{{ $item->image_gallery }}" alt="">
                        </div>
                        <div class="bg-white p-4">
                            <div class="d-flex mb-2">
                                <a class="text-primary text-uppercase text-decoration-none" href="{{ route('view.destination', ['id' => $item->destinationGallery->id]) }}">{{ $item->destinationGallery->destination_name }}</a>
                            </div>
                            <a class="h5 m-0 text-decoration-none">{{ $item->title }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Footer Start -->
    @include('user_public.template.footer')
    
    <!-- Footer End -->


    <!-- Back to Top -->
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
            $('a').on('click', function(event) {
                if (this.hash !== "") {
                    event.preventDefault();
                    var hash = this.hash;
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function(){
                        window.location.hash = hash;
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Inisialisasi carousel pertama
            $('.carousel-1').owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 5000, // Atur waktu interval sesuai kebutuhan
                nav: false,
            });

            // Inisialisasi carousel kedua
            $('.carousel-2').owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 5000, // Atur waktu interval sesuai kebutuhan
                nav: false,
            });

            // Geser carousel secara berlawanan
            setInterval(function() {
                $('.carousel-1').trigger('next.owl.carousel');
                $('.carousel-2').trigger('prev.owl.carousel');
            }, 5000); // Atur interval sesuai dengan interval autoplay di carousel

        });
    </script>

    <script>
        $.ajax({
            url: '{{route('get.destinations')}}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
            // console.log(response);
            if(response.status == 200) {
                var destinationOptions = '<option value="">Pilih destinasi</option>';
                $.each(response.data, function(index, dest) {
                destinationOptions += '<option value="' + dest.id + '">' + dest.destination_name + '</option>';
                });

                $('#destination_id').html(destinationOptions);

            }
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
                // console.log(data[0] + ': ' + data[1]);
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
    </script>

</body>

</html>
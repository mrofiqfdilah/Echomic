<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echomic Platform</title>

    <link rel="icon" href="{{ asset('image/logo2.svg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.0.1/remixicon.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="{{ asset('css/simpankomik.css') }}">

</head>
<body>

<header class="header">

    <div class="header-1">

        <a href="#" class="logo"> <i class="fas fa-book"></i> Echomic </a>

        <form action="{{ route('hasilcarikomik') }}" class="search-form" method="GET">
            <input type="search" name="keyword" placeholder="Cari komik..." id="search-box">
            <button type="submit" class="sb"><label for="search-box" class="fas fa-search"></label></button>
        </form>

        <div class="icons">
            <a href="#"  class="fas fa-bookmark"></a>
            <div id="login-btn" class="fas fa-user"></div>
        </div>

    </div>

    <div class="header-2">
        <nav class="navbar-cos">
        <a href="{{ route('home') }}">Home</a>
        <a href="" id="komik">Komik</a>
        <a href="" id="populer">Popular</a>
        <a href="" id="kontak">Contact</a>     
    </nav>
</div>

</header>


</section>

<nav class="bottom-navbar">
    <a href="{{ route('home') }}" class="fas fa-home"></a>
    <a href="" id="komik2" class="fas fa-book"></a>
    <a href="" id="populer2" class="fas fa-star"></a>
    <a href="" id="kontak2" class="fas fa-blog"></a>
</nav>

<div class="login-form-container">

    <div id="close-login-btn" class="fas fa-times"></div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <h3>Welcome {{ Auth()->user()->username }} 👋</h3>
        <span>Nama Anda</span>
        <input type="email" name="" class="box" placeholder="{{ Auth()->user()->name }}" id="">
        <span>Email Anda</span>
        <input type="password" name="" class="box" placeholder="{{ Auth()->user()->email }}" id="">
        <input type="submit" value="Log Out"  class="btn">
    </form>

</div>


<section class="sim">
    <p class="daftar-vol">Hasil pencarian untuk {{ $keyword }}</p>
    @if(count($hasilPencarian) > 0)
    <div class="box-container">
        @foreach($hasilPencarian as $hasil)
            <div class="bo3x">
                <img class="gambar" src="{{ $hasil->cover_komik }}" alt="">
                <p class="judulkom">{{ $hasil->judul_komik }}</p>
                <p class="volumekom">{{ $hasil->volumes->count() }} Volume</p>
                <button class="tombol">
                    <a href="{{ route('detaillengkap', ['id' => $hasil->id]) }}" class="baca-sekarang">Baca Sekarang</a>
                </button>
            </div>
        @endforeach
    </div>
@else
<div class="tidak">
    <img src="image/belum.png" class="bg" alt="">
    <p class="anda">Tidak ditemukan komik dengan keyword "{{ $keyword }}".</p>
</div>
@endif


</section>

@include('sweetalert::alert')


<section class="footer" id="footer">

    <div class="box-container">

        <div class="box">
            <h3>Media Social</h3>
            <a href="https://www.instagram.com/smkn1sampit_official/" target="_blank"><i class="fas fa-arrow-right"></i> Instagram </a>
            <a href="https://www.facebook.com/smkn1spt" target="_blank"><i class="fas fa-arrow-right"></i> Facebook </a>
            <a href="https://www.youtube.com/@smkn1sampit515" target="_blank"><i class="fas fa-arrow-right"></i> Youtube </a>
            <a href="https://www.smkn1-sampit.sch.id/home" target="_blank"><i class="fas fa-arrow-right"></i> Website </a>            
        </div>

        <div class="box">
            <h3>Related links</h3>
            <a href="#home"> <i class="fas fa-arrow-right"></i> home</a>
            <a href="#icon"> <i class="fas fa-arrow-right"></i> featured </a>
            <a href="#ko"> <i class="fas fa-arrow-right"></i> komik </a>
            <a href="#featured"> <i class="fas fa-arrow-right"></i> popular </a>
        </div>

        <div class="box">
            <h3>Extra link</h3>
            <a href="{{ route('simpankomik') }}"> <i class="fas fa-arrow-right"></i> Daftar Simpan </a>
            <a href="#"> <i class="fas fa-arrow-right"></i> Akun anda </a>
            <a href="#sc"> <i class="fas fa-arrow-right"></i> Cari komik</a>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="sb"> <i class="fas fa-arrow-right"></i> logout</button>
            </form>
        </div>

        <div class="box">
            <h3>Location</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3985.940877982278!2d112.94237477383413!3d-2.526206938236045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de2be56ce4bc5db%3A0xb0e172fd52ece1f8!2sSMK%20Negeri%201%20Sampit!5e0!3m2!1sen!2sid!4v1702680640337!5m2!1sen!2sid" width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        
    </div>
    <div class="credit">&copy; Copyright 2024 <span> Rofiqazk </span> | all rights reserved! </div>
</section>
<style>
    .footer .box-container .box .sb{
    display: block;
    font-size: 1.4rem;
    color:var(--light-color);
    padding:1rem 0;
}

.footer .box-container .box .sb i{
    color:var(--green);
    padding-right: .5rem;
}

.footer .box-container .box .sb:hover i{
    padding-right: 2rem;
}
</style>

<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="{{ asset('js/home.js') }}"></script>
<script>
    document.getElementById('komik').addEventListener('click', function(event) {
        event.preventDefault(); // Menghentikan tindakan default dari tautan

        // Arahkan ke halaman utama dengan menambahkan hash "#arrivals"
        window.location.href = "{{ route('home') }}#arrivals";
    });

    document.getElementById('komik2').addEventListener('click', function(event) {
        event.preventDefault(); // Menghentikan tindakan default dari tautan

        // Arahkan ke halaman utama dengan menambahkan hash "#arrivals"
        window.location.href = "{{ route('home') }}#arrivals";
    });

    document.getElementById('populer').addEventListener('click', function(event) {
        event.preventDefault(); // Menghentikan tindakan default dari tautan

        // Arahkan ke halaman utama dengan menambahkan hash "#arrivals"
        window.location.href = "{{ route('home') }}#featured";
    });

    document.getElementById('populer2').addEventListener('click', function(event) {
        event.preventDefault(); // Menghentikan tindakan default dari tautan

        // Arahkan ke halaman utama dengan menambahkan hash "#arrivals"
        window.location.href = "{{ route('home') }}#featured";
    });

    document.getElementById('kontak').addEventListener('click', function(event) {
        event.preventDefault(); // Menghentikan tindakan default dari tautan

        // Arahkan ke halaman utama dengan menambahkan hash "#arrivals"
        window.location.href = "{{ route('home') }}#footer";
    });

    document.getElementById('kontak2').addEventListener('click', function(event) {
        event.preventDefault(); // Menghentikan tindakan default dari tautan

        // Arahkan ke halaman utama dengan menambahkan hash "#arrivals"
        window.location.href = "{{ route('home') }}#footer";
    });
</script>
</body>
</html>
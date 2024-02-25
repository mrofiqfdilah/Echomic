<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echomic | Home</title>

    <link rel="icon" href="image/logo2.svg">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.0.1/remixicon.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="css/home.css">

</head>
<body>
    
<!-- header section starts  -->

<header class="header">

    <div class="header-1">

        <a href="#" class="logo"> <i class="fas fa-book"></i> Echomic </a>

        <form action="{{ route('hasilcarikomik') }}" id="sc" class="search-form" method="GET">
            <input type="search" name="keyword" placeholder="Cari komik..." id="search-box">
            <button type="submit" class="sb"><label for="search-box" class="fas fa-search"></label></button>
        </form>

     
        
        <div class="icons">
            <div id="search-btn" class="fas fa-search"></div>
            <a href="{{ route('simpankomik') }}" class="fas fa-bookmark"></a>
            <div id="login-btn" class="fas fa-user"></div>
        </div>

    </div>

    <div class="header-2">
        <nav class="navbar">
            <a href="#sc">Home</a>
            <a href="#ko">Komik</a>
            <a href="#featured">Popular</a>
            <a href="#footer">Contact</a>
        </nav>
    </div>
</header>

<nav class="bottom-navbar">
    <a href="#sc" class="fas fa-home"></a>
    <a href="#ko" class="fas fa-book"></a>
    <a href="#featured" class="fas fa-star"></a>
    <a href="#footer" class="fas fa-blog"></a>
</nav>

<!-- login form  -->

<div class="login-form-container">

    <div id="close-login-btn" class="fas fa-times"></div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <div style="display: flex; position: relative;  left:60px;">
        <h3>Hi {{ Auth()->user()->username }}   <h3 class="emoji" style="transform(20deg); margin-top:-4px; margin-left:5px; transition:0.5s;">&#x1F44B;</h3></h3>
    </div>
    <style>
        .emoji{
           animation: wave 2s infinite;
        }
        @keyframes wave {
    0% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    50% { transform: rotate(0deg); }
  }
      </style>
        <span>Nama Anda</span>
        <input type="email" name="" class="box" placeholder="{{ Auth()->user()->name }}" id="">
        <span>Email Anda</span>
        <input type="password" name="" class="box" placeholder="{{ Auth()->user()->email }}" id="">
        <input type="submit" value="Log Out"  class="btn">
    </form>
    

</div>

<!-- home section starts  -->

<section class="home" id="home">

    <div class="row">

        <div class="content">
            <h3>Welcome To Echomic</h3>
            <p>
                Sebuah Platform Membaca Komik Karya Para Siswa/Siswi DKV,
                Dengan Platform ini,
                Karya mereka dapat Dibaca Secara Online.
            </p>
            <a href="#ko" class="btn">Baca Sekarang</a>
        </div>

        <div class="swiper books-slider">
            <div class="swiper-wrapper">
                <a href="#" class="swiper-slide"><img src="image/book-1.png" alt=""></a>
                <a href="#" class="swiper-slide"><img src="image/book-2.png" alt=""></a>
                <a href="#" class="swiper-slide"><img src="image/book-3.png" alt=""></a>
                <a href="#" class="swiper-slide"><img src="image/book-4.png" alt=""></a>
                <a href="#" class="swiper-slide"><img src="image/book-5.png" alt=""></a>
                <a href="#" class="swiper-slide"><img src="image/book-6.png" alt=""></a>
            </div>
            <img src="image/stand.png" class="stand" alt="">
        </div>

    </div>

</section>






<section class="arrivals" id="ko" >

    <h1 class="heading"> <span>Daftar Komik</span> </h1>

    <div class="swiper arrivals-slider"  data-aos="fade-up"
    data-aos-easing="linear"
    data-aos-duration="1200" >
        <div class="swiper-wrapper">
    
            @foreach ($komiksTop as $komik)
            <a href="{{ route('detaillengkap', ['id' => $komik->id]) }}" class="swiper-slide box">
                <div class="image">
                    
                        <img src="{{ asset($komik->cover_komik) }}" id="kom" alt="Cover Komik">
                </div>
                <div class="content">
                    <h3 id="judu">{{ $komik->judul_komik }}</h3>
                    <div class="price" id="judu"><span>
                        
                        @php
                        $uniqueVolumes = $komik->volumes->pluck('judul_volume')->unique(); // Ambil judul_volume unik
                        $totalVolume = count($uniqueVolumes); // Hitung jumlah volume unik
                    @endphp
                
                   {{ $totalVolume }} Volume
                 
                    </span></div>
                    <div class="stars" id="judu">
                        <p class="pembaca"><i class="ri-eye-line" id="mata"></i> {{ $komik->jumlah_pembaca }}</p>
                    </div>
                </div>
            </a>
        @endforeach
        
    
        </div>
    </div>
    
    <div class="swiper arrivals-slider"  data-aos="fade-up"
    data-aos-easing="linear"
    data-aos-duration="1200" >

        <div class="swiper-wrapper">
            @foreach ($komiksBottom as $komik)
            <a href="{{ route('detaillengkap', ['id' => $komik->id]) }}" class="swiper-slide box">
                <div class="image">
                    
                        <img src="{{ asset($komik->cover_komik) }}" id="kom" alt="Cover Komik">
                </div>
                <div class="content">
                    <h3 id="judu">{{ $komik->judul_komik }}</h3>
                    <div class="price" id="judu"><span>
                        
                        @php
                        $uniqueVolumes = $komik->volumes->pluck('judul_volume')->unique(); // Ambil judul_volume unik
                        $totalVolume = count($uniqueVolumes); // Hitung jumlah volume unik
                    @endphp
                
                   {{ $totalVolume }} Volume
                 
                    </span></div>
                    <div class="stars" id="judu">
                        <div class="stars" id="judu">
                            <p class="pembaca" style="position: relative; left:-5px;"><i class="ri-eye-line" id="mata"></i> {{ $komik->jumlah_pembaca }}</p>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
        </div>
    </div>

</section>

<section class="featured"  id="featured">

    <h1 class="heading"> <span>Komik Terpopuler</span> </h1>

    <div class="swiper featured-slider" data-aos="fade-up"
    data-aos-easing="linear"
    data-aos-duration="1200">
    
        <div class="swiper-wrapper">
            @foreach($top as $komik)
            <div class="swiper-slide box">
                <div class="image">
                    <img src="{{ asset($komik->cover_komik) }}" alt="{{ $komik->judul_komik }}">
                </div>
                <div class="content">
                    <h3>{{ $komik->judul_komik }}</h3>
                    <div class="price"><i class="ri-eye-line" id="mata"></i> {{ $komik->jumlah_pembaca }}</div>
                    <a href="{{ route('detaillengkap', ['id' => $komik->id]) }}" class="btn">Lihat detail</a>
                </div>
            </div>
            @endforeach
        </div>
    
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    
    </div>
    

</section>




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
            <a href="#ko"> <i class="fas fa-arrow-right"></i> komik </a>
            <a href="#featured"> <i class="fas fa-arrow-right"></i> popular </a>
            <a href="#footer"> <i class="fas fa-arrow-right"></i> contact </a>
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
@include('sweetalert::alert')
<div class="loader-container">
    <img src="image/loader-img.gif" alt="">
</div>
 
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
<script src="js/home.js"></script>
<script>
    AOS.init();
</script>

</body>
</html>
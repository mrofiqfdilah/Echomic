<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echomic | Detail Komik</title>

    <link rel="icon" href="{{ asset('image/logo2.svg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.0.1/remixicon.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">

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
            <div style="display: none;" id="search-btn" class="fas fa-search"></div>
            <a href="{{ route('simpankomik') }}" class="fas fa-bookmark"></a>
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

<nav class="bottom-navbar">
    <a href="{{ route('home') }}" class="fas fa-home"></a>
    <a href="" id="komik2" class="fas fa-book"></a>
    <a href="" id="populer2" class="fas fa-star"></a>
    <a href="" id="kontak2" class="fas fa-blog"></a>
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
<section class="detail">
    <div class="bagian">
        @if ($komik)
            <div class="box1">
                <img src="{{ asset($komik->cover_komik) }}" class="buku" alt="">
            </div>
            <section class="hal1">
                <div class="atas">
                    <p class="judul">
                        {{ $komik->judul_komik }}
                    </p>
                    @foreach ($komik->volumes as $volume)
                        <p class="vol">Volume {{ $volume->judul_volume }}</p>
                        @break
                    @endforeach
                    <p class="dilihat"><i class="ri-eye-line" id="mata"></i> {{ $komik->jumlah_pembaca }}  </p>

                    <div class="leng">
                    <p class="author" id="auth">Author &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;{{ $komik->user->name }}</p>
                    <p class="author" id="gen">Genre &nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;{{ $komik->genre }}</p>
                    <p class="author" id="ril">Tgl Rilis &nbsp;:&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($komik->tgl_rilis)->format('d-m-Y') }}</p>
                </div>
                    <div class="sinopsis">
                        <p class="text-sino">{{ $komik->sinopsis }}</p>
                    </div>
                    <button class="btn-baca"><a href="{{ route('bacakomik', ['id' => $komik->id, 'volume' => $volume->id]) }}" class="baca-sekarang">Baca Sekarang</a></button>
                </div>
            </section>
        </section>
        @else
        <p>Komik tidak ditemukan.</p>
    @endif
        <section class="sec-tab">
            <p class="daftar-vol">Daftar Volume</p>
            <p class="desk-vol">
                Nikmati Volume terkait serta simpan volume yang menarik bagi Anda.</p>
            <table>
                <thead>
                    <tr>
                        <th>Arsip</th>
                        <th>Rilis</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($komik->volumes()->paginate(4) as $vol)
                    <tr>
                        <td class="under">
                            <a href="{{ route('bacakomik', ['id' => $komik->id, 'volume' => $vol->id]) }}">Volume {{ $vol->judul_volume }}</a>
                        </td>
                        <td>{{ $vol->created_at->format('d-m-Y') }}</td>
                        <td class="td-special">
                            <form action="{{ route('komik.input_simpankomik') }}" method="post">
                                @csrf
                                <input type="hidden" name="komik_id" value="{{ $komik->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="volume_id" value="{{ $vol->id }}">
                                <button type="submit" class="btn-bacananti">
                                    <i class="ri-bookmark-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
          
            @if ($volumes->count() > 0)
       <div class="pagane">{{ $volumes->links() }}</div> 
        @else
            <p>Tidak ada volume untuk ditampilkan.</p>
        @endif
   
       
    </div>

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
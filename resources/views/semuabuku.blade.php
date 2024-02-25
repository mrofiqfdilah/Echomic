<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Echomic Platform</title>
    <link rel="icon" href="image/logo2.svg">
</head>
<body>
    @foreach ($komiks as $komik)
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
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </a>
        @endforeach
</body>
</html>
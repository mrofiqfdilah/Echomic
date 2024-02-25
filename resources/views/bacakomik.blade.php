<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Echomic Platform</title>

    <link rel="icon" href="{{ asset('image/logo2.svg') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.0.1/remixicon.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/bacakomik.css') }}">

</head>
  <body>
   
    @if ($selectedVolume && $selectedVolume->gambarKomik)

        @foreach ($selectedVolume->gambarKomik as $gambar)
            <img  src="{{ asset($gambar->judul_gambar) }}" alt="">
        @endforeach

@else
    <p>No images found for this volume.</p>
@endif




<div class="mx-auto my-auto text-center mt-5">
    <p class="count">{{ $komentar->count() }} Komentar</p>
   <hr>
   <form action="{{ route('logika_komentar') }}" method="post">
    @csrf

    <div class="rating">
        <input type="radio" id="star5" name="rating" value="5">
        <label for="star5">&#9733;</label>

        <input type="radio" id="star4" name="rating" value="4">
        <label for="star4">&#9733;</label>

        <input type="radio" id="star3" name="rating" value="3">
        <label for="star3">&#9733;</label>
      
        <input type="radio" id="star2" name="rating" value="2">
        <label for="star2">&#9733;</label>

        <input type="radio" id="star1" name="rating" value="1">
        <label for="star1">&#9733;</label>
    </div>

    <textarea name="komentar" rows="4" placeholder="Masukkan komentar Anda"></textarea>

    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
    <input type="hidden" name="komik_id" value="{{ $komik->id }}">
    <input type="hidden" name="volume_id" value="{{ $selectedVolume->id }}">

    <button type="submit" class="submit">Submit</button>
</form>
 
</div>

@if (count($komentar) > 0)
    <div class="comments-container"> <!-- Tambahkan div dengan kelas comments-container -->
        @foreach ($komentar as $k)
            <div class="comment">
                <p class="username">{{ $k->user->name }}</p>
                <p class="user-comment">{{ $k->komentar }}</p>
                <div class="rating2">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $k->rating)
                            <span class="star">&#9733;</span>
                        @else
                            <span class="star">&#9734;</span>
                        @endif
                    @endfor
                </div>

                @auth
                    @if(auth()->user()->id == $k->user_id)
                        <form action="{{ route('hapuskomentar', ['id' => $k->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bn"><i style="color: #D04848; font-size:21px;" class="ri-delete-bin-fill"></i></button>
                        </form>
                    @endif
                @endauth
            </div>
        @endforeach
    </div>
@else
    <p style="text-align: center; position: relative; top:10px;">Belum ada komentar untuk volume ini.</p>
@endif


@include('sweetalert::alert')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
<style>
    html::-webkit-scrollbar{
  width:0.6rem;
}
    html::-webkit-scrollbar-track{
  background:#A1A9AF;
}

html::-webkit-scrollbar-thumb{
  background:#808B93;
  border-radius: 50px;
}
  </style>
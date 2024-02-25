<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Author | Tambah Komik</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <p>Form Tambah Komik</p>
        <form action="{{ route('author.tambahkomik') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth()->user()->id }}" class="form-control mb-3">
            
            <div class="mb-3">
                <label for="judul_komik" class="form-label">Judul Komik</label>
                <input type="text" name="judul_komik" class="form-control" placeholder="Masukkan judul komik" id="judul_komik">
            </div>
            
            <div class="mb-3">
                <label for="genre" class="form-label">Genre Komik</label>
                <input type="text" name="genre" class="form-control" placeholder="Masukkan genre komik" id="genre">
            </div>
            
            <div class="mb-3">
                <label for="tgl_rilis" class="form-label">Tanggal Rilis</label>
                <input type="date" name="tgl_rilis" class="form-control" id="tgl_rilis">
            </div>

            <div class="mb-3">
                <label for="sinopsis" class="form-label">Sinopsis</label>
                <textarea name="sinopsis" placeholder="Masukan sinopsis Komik" id="sinopsis" class="form-control"></textarea>
            </div>

            <div class="mb-4">
                <label for="cover_komik" class="form-label">Cover Komik</label>
           <input type="file" name="cover_komik" id="cover_komik" class="form-control">

            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
</div>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600&display=swap');
    body{
        font-family: 'Poppins', sans-serif;
        background-color:#4070F4;
    }
    p{
        letter-spacing: 0.5px;
        font-size: 25px;
        font-weight: 550;
    }
    .form-label{
        font-weight: 500;
    }
    .card{
        box-shadow: 0 5px 10px rgba('0,0,0,0.1');
    }
</style>

    <!-- Bootstrap JS (Optional, for certain features like dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

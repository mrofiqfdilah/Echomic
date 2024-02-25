<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | Edit Komik</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <p>Form Edit Komik</p>
        <form action="{{ route('komik.update', $komik->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="judul_komik" class="form-label">Judul Komik</label>
                <input type="text" value="{{ $komik->judul_komik }}" name="judul_komik" class="form-control" placeholder="Masukkan judul komik" id="judul_komik">
            </div>

            <div class="mb-3">
                <label for="tgl_rilis" class="form-label">Tanggal Rilis</label>
                <input type="date" name="tgl_rilis" value="{{ $komik->tgl_rilis }}" class="form-control" id="tgl_rilis">
            </div>
            
            <div class="mb-3">
                <label for="genre" class="form-label">Genre Komik</label>
                <input type="text" name="genre" value="{{ $komik->genre }}" class="form-control" placeholder="Masukkan genre komik" id="genre">
            </div>

            <div class="mb-3">
                <label for="sinopsis" class="form-label">Sinopsis</label>
                <textarea name="sinopsis" class="form-control" required>{{ $komik->sinopsis }}</textarea>
            </div>

            <div class="mb-3">
                <label for="cover_komik" class="form-label">Cover Komik</label>
                <input type="file" class="form-control" name="cover_komik" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label">Author</label>
                <select name="user_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $komik->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} {{ $user->role }}
                        </option>
                    @endforeach
                </select>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bagian Volume dan Gambar Komik</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
        <form action="{{ route('komik.bagian_volume_gambar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="komik_id" value="{{ $komikId }}" class="form-control mb-3">
            
            <div class="mb-3">
                <label for="judul_volume" class="form-label">Volume Ke</label>
                <input type="number" name="judul_volume" class="form-control" placeholder="Masukkan volume" id="judul_volume" required>
            </div>
            
            <div class="mb-3">
                <label for="jumlah_halaman" class="form-label">Jumlah Halaman</label>
                <input type="number" name="jumlah_halaman" class="form-control" placeholder="Jumlah halaman" id="jumlah_halaman" min="1" required>
            </div>

            <div class="mb-4" id="gambar-container">
                <label for="gambar" class="form-label">Gambar komik ke</label>
                <!-- Input fields will be dynamically added here using JavaScript -->
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
</div>
    @include('sweetalert::alert')

    <!-- Bootstrap JS (Optional, for certain features like dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Function to add image input fields dynamically
            function addImageInputs(count) {
                var container = document.getElementById('gambar-container');
                container.innerHTML = ''; // Clear existing inputs
    
                for (var i = 1; i <= count; i++) {
                    var inputDiv = document.createElement('div'); // Create a div to hold label and input
                    inputDiv.className = 'mb-2'; // Add margin-bottom to the div
    
                    var label = document.createElement('label');
                    label.for = 'gambar' + i; // Use sequential numbering for labels
                    label.className = 'form-label';
                    label.innerHTML = 'Gambar Komik ke ' + i;
    
                    var input = document.createElement('input');
                    input.type = 'file';
                    input.name = 'gambar[]';
                    input.id = 'gambar' + i; // Associate input with label
                    input.className = 'form-control';
                    input.required = true;
    
                    inputDiv.appendChild(label);
                    inputDiv.appendChild(input);
                    container.appendChild(inputDiv);
                }
            }
    
            // Add event listener to jumlah_halaman input
            var jumlahHalamanInput = document.getElementById('jumlah_halaman');
            jumlahHalamanInput.addEventListener('change', function () {
                var count = parseInt(this.value) || 1;
                addImageInputs(count);
            });
    
            // Initial setup based on the default value
            var initialCount = parseInt(jumlahHalamanInput.value) || 1;
            addImageInputs(initialCount);
        });
    </script>
    
    

@include('sweetalert::alert')
</body>
</html>
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


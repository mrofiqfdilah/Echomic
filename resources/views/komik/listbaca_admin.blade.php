@if ($selectedVolume && $selectedVolume->gambarKomik)

        @foreach ($selectedVolume->gambarKomik as $gambar)
            <img  src="{{ asset($gambar->judul_gambar) }}" alt="">
        @endforeach

@else
    <p>No images found for this volume.</p>
@endif
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600&display=swap');

body {
    background-color: #222222;
    height: 100vh;
    color: #fff;
    overflow-x: hidden;
    font-family: 'Poppins', sans-serif;
}

/* Add these styles to your existing CSS */
/* Add these styles for responsive images */
img {
    max-width: 60%;
    height: auto;
    display: block;
    margin: 0 auto;
}




form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.rating {
    display: flex;
    justify-content: center;
    position: relative;
    left: -375px;
    top : -18px;
    flex-direction: row-reverse; /* Arrange from right to left */
}

.rating input {
    display: none;
}

.rating label {
    font-size: 30px;
    cursor: pointer;
    color: #fff; /* Star color */
    margin-right: 10px; /* Adjust the margin to create space between stars */
}

.rating input:checked ~ label {
    color: #ffc107; /* Star color when checked */
}

textarea {
    margin: 10px 0;
    padding: 10px;
    width: 920px;
    box-sizing: border-box;
    border: 1px solid #fff;
    position: relative;
    top: -20px;
    left: -3px;
    border-radius: 5px;
    color: #fff;
    background-color: #333;
}

.submit{
    padding: 10px 20px;
    background-color: #27ae60;
    color: #fff;
    border: none;
    position: relative;
    left: -410px;
    top: -10px;
    border-radius: 5px;
    letter-spacing: 1px;
    cursor: pointer;
}
.comments-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; /* Mengatur agar semua kotak komentar berada di tengah */
    gap: 20px;
    position: relative;
    top: 10px;
}
.comment {
    width: calc(50% - 10px); /* Set lebar agar 2 kotak dapat berdampingan dengan jarak 20px di antara */
    max-width: 450px; /* Maksimum lebar kotak komentar */
    height: 150px; /* Tinggi kotak komentar */
    padding: 10px;
    border: 1px solid #B4B4B8;
    border-radius: 5px;
    box-sizing: border-box;
}

.btn {
    position: relative;
    left: 190px;
    top: -99px;
}



   

.username {
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 20px;
}

.user-comment {
    margin-bottom: 5px;
    text-align: justify;
    width: 500px;
    color: #fff;
    
}

.rating2 {
    font-size: 30px;
    position: relative;
    left: 0px;
   
}

.star {
    color: #FFD700; /* Set the color of the star to gold or any color you prefer */
    margin-right: 5px;
}


hr {
    width: 915px;
    height: 20px;
    margin: 0 auto; /* Set margin to auto for horizontal centering */
}

.count{
    position: relative;
    left: -410px;
    letter-spacing: 0.5px;
}



@media (max-width: 768px) {
    img {
        max-width: 100%; /* Adjust for smaller screens */
    }
    hr{
        width: 95%;
    }
    textarea{
        width: 348px;
        position: relative;
        left: -3px;
    }
    .rating{
        position: relative;
        left: -90px;
    }
    .submit{
        position: relative;
        left: -125px;
    }
   .count{
    position: relative;
    left: -125px;
   }
   .comment{
    position: relative;
    left: 5px;
   }
}

</style>
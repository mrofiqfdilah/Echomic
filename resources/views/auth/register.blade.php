<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/register.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Echomic | Register</title>
    <link rel="icon" href="image/logo2.svg">
</head>
<body>
    <div class="container">
        <header>Register</header>
        <p class="sudah">Sudah punya akun? <a href="{{ route('login') }}" style="color: #27ae60; text-decoration: none; ">Login sekarang</a></p>
        <form action="{{ route('register') }}" method="POST">
          @csrf
            <div class="form first">
                <div class="details personal">
                    <div class="fields">
                        <div class="input-field">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" placeholder="Masukan nama lengkap" required>
                        </div>
                    
                        <div class="input-field">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" placeholder="Masukan tanggal lahir" required>
                        </div>
                    </div>
                    
                    <div class="fields">
                        <div class="input-field" style="position: relative; top:-10px;">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Masukan email" required>
                        </div>
                    
                        <div class="input-field" style="position: relative; top: -10px;">
                          <label>Password </label>
                          <div class="password-container">
                              <input type="password" class="password" name="password" placeholder="Masukan password" required>
                          </div>
                      </div>
                      
                      

                          
                    
                        <div class="input-field">
                            <label>Jenis kelamin</label>
                            <select required name="gender">
                                <option disabled selected>Pilih jenis kelamin</option>
                                <option value="laki-laki">Laki Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                    
                        <div class="input-field">
                            <label>Username</label>
                            <input type="text" name="username" placeholder="Masukan nama panggilan" required>
                        </div>
                    </div>
                    
                    <button class="nextBtn" type="submit">
                        <span class="btnText">Register sekarang</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                </div> 
            </div>
        </form>
    </div>

   
</body>
</html>
<script>
  const container = document.querySelector(".container"),
    pwShowHide = document.querySelectorAll(".showHidePw"),
    pwFields = document.querySelectorAll(".password"),
    signUp = document.querySelector(".signup-link"),
    login = document.querySelector(".login-link");

  //   js code to show/hide password and change icon
  pwShowHide.forEach(eyeIcon =>{
      eyeIcon.addEventListener("click", ()=>{
          pwFields.forEach(pwField =>{
              if(pwField.type ==="password"){
                  pwField.type = "text";

                  pwShowHide.forEach(icon =>{
                      icon.classList.replace("uil-eye-slash", "uil-eye");
                  })
              }else{
                  pwField.type = "password";

                  pwShowHide.forEach(icon =>{
                      icon.classList.replace("uil-eye", "uil-eye-slash");
                  })
              }
          }) 
      })
  })

  // js code to appear signup and login form
  signUp.addEventListener("click", ( )=>{
      container.classList.add("active");
  });
  login.addEventListener("click", ( )=>{
      container.classList.remove("active");
  });
</script>

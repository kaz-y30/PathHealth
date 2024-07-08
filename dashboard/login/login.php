<?php
include "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="../../style/login/login.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  </head>
  <body>
      <div class="container">
        <div class="content">
          <div class="logoph">
            <img src="../../asset/logo3.png" width="300" alt="">
          </div>
          <!-- <h2 class="logo"><i class="bx bxl-squarespace"></i>PathHealth</h2> -->
          <div class="text-sci">
            <h2>Welcome</h2>
            <h3>To Our New Website</h3>
            <p>Pengembangan Sistem Informasi</p>

            <div class="social-icons">
              <a href=""><i class="bx bxl-linkedin"></i></a>
              <a href=""><i class="bx bxl-facebook"></i></a>
              <a href=""><i class="bx bxl-instagram"></i></a>
              <a href=""><i class="bx bxl-twitter"></i></a>
            </div>
          </div>
        </div>

        <div class="logreg-box">
          <div class="form-box login">
            <form action="login_p.php" method="post">
              <h2>Sign In</h2>

              <div class="input-box">
                <span class="icon"></span>
                <input type="email" name="email" required />
                <label>Email</label>
              </div>

              <div class="input-box">
                <span class="icon"><i class="bx bx-lock"></i></span>
                <input type="password" name="password" required />
                <label>Password</label>
              </div>

              <div class="remember-forgot">
                <label><input type="checkbox" name="" id="" />Remember Me</label>
                <a href="#">Forgot Password</a>
              </div>

              <button type="submit" class="btn btn-info">Sign In</button>

              <div class="login-register">
                <p>Don't have an account?   <a href="../regis/regis.php" class="register-link">Sign Up</a></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    <script src="login.js"></script>
  </body>
</html>

<?php mysqli_close($conn); ?>

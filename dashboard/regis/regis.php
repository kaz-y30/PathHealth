<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../../style/regis/regis.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="logoph">
                <img src="../../asset/logo1.png" width="300" alt="">
            </div>
            <div class="text-sci">
                <h2>Welcome</h2><h3>To Our New Website</h3>
                <p>Pengembangan Sistem Informasi</p>
                <div class="social-icons">
                    <a href=""><i class='bx bxl-linkedin'></i></a>
                    <a href=""><i class='bx bxl-facebook'></i></a>
                    <a href=""><i class='bx bxl-instagram'></i></a>
                    <a href=""><i class='bx bxl-twitter'></i></a>
                </div>
            </div>
        </div>

        <div class="logreg-box">
            <div class="form-box register">
                <form action="regis_p.php" method="post">
                    <h2>Sign Up</h2>

                    <div class="input-box">
                        <span class="icon"><i class='bx bx-user'></i></span>
                        <input type="text" name="username" required>
                        <label>Username</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bx-user'></i></span>
                        <input type="text" name="fullname" required>
                        <label>Full Name</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bx-envelope'></i></span>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bx-lock'></i></span>
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bx-user-circle'></i></span>
                        <select class="pilihan" name="register_as" required>
                            <option value="user">Pengguna</option>
                            <option value="psychologist">Psikolog</option>
                        </select>
                    </div>


                    <div class="remember-forgot">
                        <label><input type="checkbox" name="agree_terms" required>I agree to the terms & condition</label>
                    </div>

                    <button type="submit" class="btn">Sign Up</button>

                    <div class="login-register">
                        <p>Already have an account? <a href="../login/login.php" class="login-link btn btn-info">Sign In</a></p>
                    </div>
                </form>
            </div>    
        </div>
    </div>
    <script src="../login/login.js"></script>
</body>
</html>

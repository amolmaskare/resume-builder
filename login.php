<!-- <php 
session_start();
if(isset($_SESSION["user"])){
header("Location:index.php");
}
?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
   
    <div class="wrapper1">
        <div>
            <h1>The Best Free Online Resume Builder</h1><br>
            <p>A Quick and Easy Way to Create Your Professional Resume.</p>
        </div>
    </div>
    <div class="wrapper">

      <?php
      if(isset($_POST["submit"])){
        $email = $_POST["email"];
        $password = $_POST["password"];

        $host = "localhost";
        $dbuser = "root";
        $dbpassword ="";
        $dbname = "login_register";
        $conn = mysqli_connect($host, $dbuser, $dbpassword, $dbname);

        if(!$conn) {
            die("Something went wrong");
        }

        
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        if($user) {
        //     if($user["password"] == $password));
            if (password_verify($password, $user["password"])) {
                session_start();
                $_SESSION["user"]="yes";
               header("Location: registration.php");
               die();
            }
            else{
                echo "<div class='alert alert-danger'>Password does not match</div>"; 
            }
        }
        else{
            echo "<div class='alert alert-danger'>Email does not match</div>";
        }

      }
      ?>
        <form action="login.php" method="post">
            <h1>Welcome to <span>Resume Builder</span></h1><br><br>

            <h2>Login</h2>
            <div class="input-box">
                <input type="text" placeholder="Email" name="email">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password">
                <i class='bx bxs-lock-alt'></i>
            </div>
            <!-- <div class="remember-forgot">
                <label><input type="checkbox">Remember me</label>

                <a href="#">Forgot Password?</a>    
            </div> -->

            <button type="Sumbit" class="button" name="submit" value="submit" >Login</button>
            <div class="register-link">
                <p>Don't have an account?
                    <a href="#">Register</a>
                </p>

            </div>
        </form>
    </div>
    
</body>
</html>
<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
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
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $passwordConfirm = $_POST["confirm_password"];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $errors = array();

        
            if (empty($username) OR empty($email) OR empty($password) OR empty($passwordConfirm)) {
                array_push($errors, "All fields are required");
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }
            if(strlen($password)<8) {
                array_push($errors, "Password must be at least 8 charachers long");

            }
            if($password!=$passwordConfirm) {
                array_push($errors, "Password does not match");
            }
             $host="localhost";
             $dbuser="root";
             $dbpassword="";
             $bdname="login_register";
             $conn=mysqli_connect($host, $dbuser, $dbpassword, $bdname);

             if(!$conn){
                die("someting went wrong");
             }

             $query = "SELECT * FROM users WHERE email='$email' ";
             $result = mysqli_query($conn, $query);
             $data = mysqli_num_rows($result);

             if($data > 0){
                array_push($errors, "Email are already exist");
             }

            if(count($errors)>0){
                foreach ($errors as $errors) {
                    echo "<div class='alert alert-danger'>$errors</div>";
                }
            }else{
                    $querys = "INSERT INTO users (username,email,password) VALUES (?, ?, ?)";
                    $end = mysqli_stmt_init($conn);
                    $res = mysqli_stmt_prepare($end, $querys);

                    if($res){
                        mysqli_stmt_bind_param($end, "sss",$username, $email, $hash);
                        mysqli_stmt_execute($end);
                    }

                   
                }

       }
     ?>
        <form action="registration.php"  method="post">
            <h1>Welcome to <span>Resume Builder</span></h1>
            <div class="input-box">
                <input type="text" placeholder="Email Address" name="email">
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Username" name="username">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password" >
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Confirm Password" name="confirm_password">
                <i class='bx bxs-lock-alt'></i>
            </div>
        
            <button type="Sumbit" class="button" name="submit">Register</button>
            <div class="register-link">
                <p>Already have an account?
                    <a href="#">Login</a>
                </p>

            </div>
        </form>
    </div>
</body>
</html>
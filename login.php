<?php 

require_once("config.php");

if(isset($_POST['login'])){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM users WHERE username=:username OR email=:email";
    $stmt = $db->prepare($sql);
    
    // bind parameter to query
    $params = array(
        ":username" => $username,
        ":email" => $username
    );

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // if user registered
    if($user){
        // verify password
        if(password_verify($password, $user["password"])){
            // Session
            session_start();
            $_SESSION["user"] = $user;
            // login success
            header("Location: timeline.php");
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login MyTutor</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">

        <p>&larr; <a href="index.php">Home</a>

        <h4>Enter to MyTutor</h4>
        <p>Doesn't have an account yet? <a href="register.php">Register here</a></p>

        <form action="" method="POST">

            <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control" type="text" name="username" placeholder="Enter Your Username" />
            </div>


            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" placeholder="Enter Your Password" />
            </div>

            <div class="form-group">
            <input type="checkbox" name="remember me" id="remember me" > Remember Me
            </div>

            <input type="submit" class="btn btn-success btn-block" name="login" value="Login" />

        </form>
            
        </div>

        <div class="col-md-6">
           
        </div>

    </div>
</div>
    
</body>
</html>
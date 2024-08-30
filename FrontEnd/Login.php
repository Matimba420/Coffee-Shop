
<!DOCTYPE html>
<html lang="en" >
<html>
<head>
  <!--Bootsrap 4 CDN-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     
    <!--Fontawesome CDN-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

  <!--Custom styles-->
  <link rel='stylesheet' href="assets/css/style.css"/>

    <style type="text/css">
    #buttn{
      color:#fff;
      background-color: #ff3300;
    }
    </style>


</head>

<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'Ecommence';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$error = '';

if (isset($_POST['submit'])) {
    if (!isset($_POST['username'], $_POST['password'])) {
        $error = 'Please fill both the username and password fields!';
    } else {
        if ($stmt = $con->prepare('SELECT user_id, password FROM registeruser WHERE username = ?')) {
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_id, $password);
                $stmt->fetch();

                if (password_verify($_POST['password'], $password)) {
                    session_regenerate_id();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['user_id'] = $user_id;
                    header('Location: LoggedinHomePage.php');
                    exit;
                } else {
                    $error = 'Incorrect username and/or password!';
                }
            } else {
                $error = 'Incorrect username and/or password!';
            }
            $stmt->close();
        }
    }
}
$con->close();
?>


<style>
    @import url('https://fonts.googleapis.com/css?family=Numans');

    html,body{
    background-image: url('images/img/login-page.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    height: 100%;
    font: normal 16px "Raleway","Helvetica Neue",Helvetica,Arial,sans-serif;
    }

    .container{
    height: 100%;
    align-content: center;
    }

    .card{
    height: 420px;
    margin-top: auto;
    margin-bottom: auto;
    width: 400px;
    background-color: rgba(0,0,0,0.5) !important;
    }

    .social_icon span{
    font-size: 60px;
    margin-left: 10px;
    color: #FFFFFF;
    }

    .social_icon span:hover{
    color: white;
    cursor: pointer;
    }

    .card-header h3{
    color: white;
    }

    .social_icon{
    position: absolute;
    right: 20px;
    top: -45px;
    }

    .input-group-prepend span{
    width: 50px;
    background-color: #ffffff;
    color: black;
    border:0 !important;
    }

    input:focus{
    outline: 0 0 0 0  !important;
    box-shadow: 0 0 0 0 !important;

    }

    .remember{
    color: white;
    }

    .remember input
    {
    width: 20px;
    height: 20px;
    margin-left: 15px;
    margin-right: 5px;
    }

    .login_btn{
    color: black;
    background-color: #447EBA;
    width: 100px;
    }

    .login_btn:hover{
    color: black;
    background-color: white;
    }

    .links{
    color: white;
    }

    .links a{
    margin-left: 4px;
    }

</style>
<body>
<div class="container">
  <div class="d-flex justify-content-center h-100">
    <div class="card">
      <div class="card-header" align="center">
          <a class="navbar-brand" href="index.php"></a>         
      </div>
      <div class="card-body">
        <!-- Error message display -->
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
          </div>
        <?php endif; ?>

        <form action="" method="post">
          <div class="input-group form-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Enter Your Username" name="username">
          </div>
          <div class="input-group form-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" class="form-control" placeholder="Enter your Password" name="password">
          </div>
          <div class="row align-items-center remember">
            <input type="checkbox">Remember Me
          </div>
          <div class="form-group">
            <input align="center" type="submit" id="buttn" name="submit" value="Login" class="btn float-right login_btn">
          </div>
        </form>
      </div>
      <div align="center">
        <div class="card-footer">
          <div class="d-flex justify-content-center links">
            Don't have an account?<a href="Register.php"> Sign Up </a><br>
          </div>
          <div class="d-flex justify-content-center">
            <a href="ForgetPassword.php">Forgot your password?</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

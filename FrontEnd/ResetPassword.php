<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     
     <!--Fontawesome CDN-->
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
 
   <!--Custom styles-->
   <link rel='stylesheet' href="assets/css/style.css"/>
 
    
   <?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'Ecommence';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the user's password
    $stmt = $con->prepare('UPDATE registeruser SET password = ? WHERE email = ?');
    
    if ($stmt === false) {
        exit('Prepare failed: ' . htmlspecialchars($con->error));
    }
    
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        // Redirect to login page after successful password reset
        header('Location: Login.php');
        exit;
    } else {
        $error = "Password not reset";
    }
    $stmt->close();
}
$con->close();
?>


<style type="text/css">
     #buttn{
       color:#fff;
       background-color: #ff3300;
     }
     </style>

<style>
    
   
    html,body{
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


    .card-header h3{
    color: white;
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
                    <label for="exampleInputEmail1">Enter your New Password</label>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="password" placeholder="New Password" id="password" required>
                        <input type="hidden" name="email" id="email" value="<?php echo $_GET['id'] ?>" required>
                        <input type="submit" name="submit" value="Update password">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>









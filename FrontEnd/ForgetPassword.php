<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
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
 
<?php

 session_start();
    // Change this to your connection info.
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'Ecommence';

        // Create connection
        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        

            $stmt = $con->prepare('SELECT user_id FROM registeruser WHERE email = ?');
            if ($stmt === false) {
                exit('Prepare failed: ' . htmlspecialchars($con->error));
            }
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                header('Location:ResetPassword.php?id='.$_POST['email']);
            } else{
                $error = "Username is not in the database";
            }
        }
?>



<style>
   
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
          
        <label for="exampleInputEmail1">Email</label>
          <div class="input-group form-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Enter  Email" name="email">
            
				<input type="submit" name="submit" value="Submit">
          </div>
        </form>
     

      </div>
     
    </div>
  </div>
</div>
</body>
</html>




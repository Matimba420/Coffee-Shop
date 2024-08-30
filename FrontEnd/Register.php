<?php
session_start();

// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'Ecommence';

// Create connection
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Check connection
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $contacts = $_POST['contacts'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    // Form validation
    if (!empty($username) && !empty($email) && !empty($password) && $password === $confirmpassword) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $con->prepare("INSERT INTO registeruser (username, firstname, lastname, email, contacts, password) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            exit('Prepare failed: ' . htmlspecialchars($con->error));
        }
        $stmt->bind_param("ssssss", $username, $firstname, $lastname, $email, $contacts, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            // Registration successful, log the user in
            $stmt->close();

            // Prepare the login statement
            $stmt = $con->prepare('SELECT user_id FROM registeruser WHERE username = ?');
            if ($stmt === false) {
                exit('Prepare failed: ' . htmlspecialchars($con->error));
            }
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_id);
                $stmt->fetch();

                // Create sessions
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $username;
                $_SESSION['id'] = $user_id;
                header('Location:Login.php');
                exit;
            } else {
                $error= 'No account found for the provided username.';
            }

            $stmt->close();
        } else {
            $error= "Execute failed: " . htmlspecialchars($stmt->error);
        }
    } else {
        $error= "All fields are required and passwords must match!";
    }
}

$con->close();
?>



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

<style>
  

    html,body{
    height: 100%;
    font: normal 16px "Raleway","Helvetica Neue",Helvetica,Arial,sans-serif;
    }

    .header_section1 {
    width: 100%;
    float: left;
    height: auto;
    background-size: 100%;
    background-repeat: no-repeat;
     }

    .container{
    height: 100%;
    align-content: center;
    }

    .card{
    height: 720px;
    margin-top: auto;
    margin-bottom: auto;
    width: 600px;
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

    .Register_btn{
    color: black;
    background-color: #447EBA;
    width: 100px;
    }

    .Register_btn:hover{
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

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>

            <div class="card-header" align="center">
                <a class="navbar-brand" href="index.php"> 
                </a>         
                <div >
                </div>
            </div>
            <div class="card-body">

                <form  action="" method="post">
                <label for="InputUserName">User Name</label>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Username" name="username">
                </div>

                <label for="InputFisrtName">First Name</label>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter First Name" name="firstname">
                </div>

                <label for="inputLastName">Last Name</label>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Last Name" name="lastname">
                </div>

                <label for="inputEmail">Email</label>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter  Email" name="email">
                </div>

                <label for="inputContacts">Contacts</label>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Contacts" name="contacts">
                </div>

                <label for="inputPassword">Password</label>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter Password" name="password">
                </div>

                <label for="ConfirmPassword">Confirm Password</label>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control" placeholder="Confirm Password" name="confirmpassword">
                </div>

                <div class="form-group">
                    <input align="center" type="submit" id="buttn" name="submit" value="Register" class="btn float-right Register_btn">
                </div>
                </form>
            </div>
            
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                <a href="Index.php">Go back</a>
                </div>
            </div>
            </div>
        </div>
        </div>
</body>
</html>
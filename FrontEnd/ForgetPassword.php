<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel='stylesheet' href="assets/css/style.css"/>
    <style type="text/css">
        #buttn {
            color: #fff;
            background-color: #ff3300;
        }
    </style>
    <style>
        html, body {
          
            background-size: cover;
            background-repeat: no-repeat;
            height: 100%;
            font: normal 16px "Raleway", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .container {
            height: 100%;
            align-content: center;
        }
        .card {
            height: 420px;
            margin-top: auto;
            margin-bottom: auto;
            width: 400px;
            background-color: rgba(0, 0, 0, 0.5) !important;
        }
        .card-header h3 {
            color: white;
        }
        .input-group-prepend span {
            width: 50px;
            background-color: #ffffff;
            color: black;
            border: 0 !important;
        }
        input:focus {
            outline: 0 0 0 0 !important;
            box-shadow: 0 0 0 0 !important;
        }
    </style>
</head>
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

                    <!-- OTP Request Form -->
                    <?php if (!isset($_SESSION['otp']) && !isset($_GET['otp_requested'])): ?>
                        <form action="" method="post">
                            <label for="exampleInputEmail1">Email</label>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter Email" name="email" required>
                                <input type="submit" name="submit" value="Request OTP" id="buttn">
                            </div>
                        </form>
                    <?php elseif (isset($_GET['otp_requested'])): ?>
                        <!-- OTP Verification Form -->
                        <form action="verify_otp.php" method="POST">
                            <label for="otp">Enter OTP:</label>
                            <input type="number" id="otp" name="otp" required>
                            <button type="submit">Verify OTP</button>
                        </form>
                    <?php endif; ?>

                    

                </div>
            </div>
        </div>
    </div>

    <?php
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'src/PHPMailer.php';
    require 'src/Exception.php';
    require 'src/SMTP.php';

    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'Ecommence';

    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];

        $stmt = $con->prepare('SELECT user_id FROM registeruser WHERE email = ?');
        if ($stmt === false) {
            exit('Prepare failed: ' . htmlspecialchars($con->error));
        }
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_email'] = $email;

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'matimbamanyondos@gmail.com';
                $mail->Password = 'giwwntilkrqykmyn';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('matimbamanyondos@gmail.com', 'OTP Verification');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body = 'Your One-Time Password (OTP) is: <b>' . $otp . '</b>';

                $mail->send();
                header('Location: ' . $_SERVER['PHP_SELF'] . '?otp_requested=true');
                exit();
            } catch (Exception $e) {
                echo "OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $error = "Email address is not registered";
        }
    }
    ?>
</body>
</html>

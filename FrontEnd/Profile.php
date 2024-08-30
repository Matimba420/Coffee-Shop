<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'Ecommence';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $con->prepare('SELECT password,firstname,lastname,contacts,email, username FROM registeruser WHERE user_id = ?');
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($con->error));
}

// In this case, we use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['user_id']); // 'i' specifies that user_id is an integer
$stmt->execute();
$stmt->bind_result($password,$fistname,$lastname,$contacts,$email, $username);
$stmt->fetch();
$stmt->close();
$con->close();
?>

<style>
* {
    box-sizing: border-box;
    font-size: 16px;
}
body {
    background-color: rgba(0,0,0,0.5) !important;
}
.content {
	width: 1000px;
	margin: 0 auto;
	
}
.content h2 {
	margin: 0;
	padding: 25px 0;
	font-size: 22px;
	border-bottom: 1px solid #e0e0e3;
	color: #4a536e;
}
.content > p, .content > div {
	box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);
	margin: 25px 0;
	padding: 25px;
	background-color: #fff;
}
.content > p table td, .content > div table td {
	padding: 5px;
}
.content > p table td:first-child, .content > div table td:first-child {
	font-weight: bold;
	color: #4a536e;
	padding-right: 15px;
}
.content > div p {
	padding: 5px;
	margin: 0 0 10px 0;
}

.white-title {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
}
.profile-title {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: left;
}

</style>

<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
			<h1 class="profile-title">Coffee Shop</h1>
				<a href="index.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
		<h1 class="white-title">My Profile</h1>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>User Name:</td>
						<td><?=htmlspecialchars($username, ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>First Name:</td>
						<td><?=htmlspecialchars($fistname, ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Last Name:</td>
						<td><?=htmlspecialchars($lastname, ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Contacts number:</td>
						<td><?=htmlspecialchars($contacts, ENT_QUOTES)?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=htmlspecialchars($password, ENT_QUOTES)?></td>
					</tr>
					<!-- Add the email column if you have it in your database -->
					<tr>
						<td>Email address:</td>
						<td><?=htmlspecialchars($email, ENT_QUOTES)?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>

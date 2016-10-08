<?php

include('includes/session.php');
if (isset($admin_username) && isset($admin_id))
	header('location: dashboard.php');

include('includes/convars.php');

$dbc = mysqli_connect(HOST, USER, PASSWORD, DBNAME) or die(mysqli_error());

if (isset($_POST['login']))
{
	$errors = array();

	//form validation
	if (isset($_POST['username']) && $_POST['username'] != '')
		$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
	else
		$errors['username'] = "Please enter username";


	if (isset($_POST['password']) && $_POST['password'] != '')
		$password = mysqli_real_escape_string($dbc, trim($_POST['password']));
	else
		$errors['password'] = "Please enter password";


	//login process
	if (empty($errors))
	{
		$query = "SELECT * FROM blog_admin WHERE admin_username = '$username'";
		$result = mysqli_query($dbc, $query);

		if (mysqli_num_rows($result) == 1)
		{
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

			if (password_verify($password, $row['admin_password']))
			{
				session_regenerate_id();
				$_SESSION['admin_username'] = $username;
				$_SESSION['admin_id'] = $row['admin_id'];
				mysqli_close($dbc);
				header('location: dashboard.php');
			}
			else
			{
				$errors['wrong_password'] = "invalid password entered";
				mysqli_close($dbc);
			}
		}
		else
		{
			$errors['wrong_username'] = "invalid username entered";
			mysqli_close($dbc);
		}
	}
}


?>

<!DOCTYPE>
<html>
<head>
<title>Admin Login</title>

 <?php include('includes/bootstrap.php'); ?>

<style type="text/css">
	
	.login-form	{
		margin-left: 2%;
		margin-top: 2%;
	}

	.error {
		color: red;
		font-family: sans-serif;
	}

</style>

</head>

<body class="bottom">

<div class="page-header">
<h1>Login to Admin Dashboard</h1>
</div>

<div class="login-form">

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

	<div class="row">
	<div class="form-group col-sm-3">
	<label for="username">Username: </label>
	<input type="text" class="form-control" name="username" id="username" autofocus>
	<?php if (isset($errors['username'])) echo '<span class="error">'. $errors['username'] .'</span>'; ?>
	<?php if (isset($errors['wrong_username'])) echo '<span class="error">'. $errors['wrong_username'] .'</span>'; ?>
	</div>
	</div>

	<div class="row">
	<div class="form-group col-sm-3">
	<label for="password">Password: </label>
	<input type="password" class="form-control" name="password" id="password">
	<?php if (isset($errors['password'])) echo '<span class="error">'. $errors['password'] .'</span>'; ?>
	<?php if (isset($errors['wrong_password'])) echo '<span class="error">'. $errors['wrong_password'] .'</span>'; ?>
	</div>
	</div>

	<button type="submit" class="btn btn-default" name="login" id="login">Login</button>

	</form>
</div>

</body>
</html>
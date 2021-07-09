<?php include('main.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration Form</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>LOGIN</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" placeholder="Enter Username"  name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" placeholder="Enter Password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="user_login">LOGIN</button>
  	</div>
  	<p>
  		Not yet a member?...Please <a href="register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>
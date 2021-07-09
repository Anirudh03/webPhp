<?php include('main.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration form</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>USER REGISTRATION</h2>
  </div>
	
  <form method="post" action="register.php" enctype="multipart/form-data">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" placeholder="Enter Username" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" placeholder="Enter Email" name="email" value="<?php echo $email; ?>">
  	</div>
	<div class="input-group">
  	  <label>Firstname</label>
  	  <input type="text" placeholder="Enter Firstname" name="firstname" value="<?php echo $firstname; ?>">
  	</div>
	<div class="input-group">
  	  <label>Lastname</label>
  	  <input type="text" placeholder="Enter Lastname" name="lastname" value="<?php echo $lastname; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" placeholder="Enter Password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" placeholder="Repeat Password"  name="password_2">
  	</div>
	<div class="input-group">
  	  <label>Upload</label>
  	  <input type="file" name="myFile">
  	</div>
  	<div class="input-group">	
  	  <button type="submit" class="btn" name="reg_user">REGISTER</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>
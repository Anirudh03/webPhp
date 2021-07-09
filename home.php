<?php
session_start();
/*if (isset($_SESSION)) {
	<script language="javascript" type="text/javascript" >
	
	</script>
    session_destroy();
    }*/
if (!isset($_SESSION['username']))
{
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout']))
{
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

?>

<html>

<head>
<script src="Scripts/query-1.7.1.js"> </script>
 <script language="javascript" type="text/javascript" >
 function preventBack()
 {
 window.history.forward();
 }
 setTimeout("preventBack",0);
 window.onunload=function(){null};
 </script>
	<title>Home Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	 </head>
<body>

<div class="header">
	<h2>Home Page</h2>
	<p> <strong> <a href="home.php?logout='1'" style="color: blue;text-align: right;">Logout</a> </strong></p>
</div>
<div class="content">
  <!--Display logged in message-->
  	<?php if (isset($_SESSION['success'])): ?>
      <div class="success" >
      	<h3 style="text-align: center;">
          <?php
    echo $_SESSION['success'];
    unset($_SESSION['success']);

?>
      	</h3>
      </div>
  	<?php
endif ?>
    <!-- Displaying  user information -->
	
    <?php if (isset($_SESSION['username'])): ?>
	 
    	<p style="text-align: center;">Welcome User <strong><?php
    echo $_SESSION['username'];

?></strong></p>
		<p >Below are your details ...<strong></strong></p>
		<p>FirstName  :<strong><?php
    $conn = new mysqli('localhost', 'root', 'cloud09', 'custRegistration');

    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    //getting userdetails from the table to print the values
    $var = $_SESSION['username'];
    $sql = "SELECT id ,email, firstname, lastname FROM usersreg where username='$var'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {
        // output data of each row
        while ($row = $result->fetch_assoc())
        {
            $id = $row["id"];
            $email = $row["email"];
            $firstname = $row["firstname"];
            $lastname = $row["lastname"];
        }
    }
    else
    {
        echo "0 results";
    }
    $conn->close();
    $conn1 = new mysqli('localhost', 'root', 'cloud09', 'custRegistration');

    if ($conn1->connect_error)
    {
        die("Connection failed: " . $conn1->connect_error);
    }
    //taking file id and from that getting the word count and download count
    $sql1 = "SELECT * from files  where id='$id'";
    $result1 = $conn1->query($sql1);

    if ($result1->num_rows > 0)
    {
        while ($row = $result1->fetch_assoc())
        {
            $words = $row[words];
            $name = $row[name];
            $download_counter = $row[download];
        }
    }
    else
    {
        echo "0 results";
    }
    $_SESSION['id'] = $id;
    echo $firstname
?></strong></p>
		<p>LastName  :<strong><?php echo $lastname ?></strong></p>
		<p>EmailID    :<strong><?php echo $email ?></strong></p>
    	 <p>Total word count for uploaded file   : <strong><?php
    echo $words
?></strong></p>
		
       <p>Number of downloads of uploaded file  :<strong><?php echo $download_counter ?></strong></p>
    <?php
endif ?>
	<!--<p>ID: <strong><?php echo $id ?></strong></p>-->
	<p>Download the uploaded File :<strong> <a href="downloads.php?file_id=<?php echo $id ?>"  style="color: Red;"><?php
echo $name
?></a>
	</strong></p>
    
	
</div>
	  </body>
	 

</html>

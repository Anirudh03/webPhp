<?php
session_start();

$username = "";
$email = "";
$errors = array();

// db connection to aws db server phpMyAdmin
$db = mysqli_connect('localhost', 'root', 'cloud09', 'custRegistration');
if (!$db)
{
    die('ERROR: Could not connect: ' . mssql_get_last_message());
}

// taking values of from the register form
if (isset($_POST['reg_user']))
{

    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $filename = $_FILES['myFile']['name'];
    $destination = 'uploads/' . $filename;
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $file = $_FILES['myFile']['tmp_name'];
    $size = $_FILES['myFile']['size'];

    if (!in_array($extension, ['txt']))
    {
        array_push($errors, "The file extension must be .txt");
    }
    elseif ($_FILES['myFile']['size'] > 1000000)
    { // file shouldn't be larger than 1Megabyte
        array_push($errors, "File too large!");
    }
    // Validating the form
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username))
    {
        array_push($errors, "Username is an required field");
    }
    if (empty($email))
    {
        array_push($errors, "Email id is an required field");
    }
    if (empty($password_1))
    {
        array_push($errors, "Password is an required field");
    }
    if ($password_1 != $password_2)
    {
        array_push($errors, "Given two passwords do not match");
    }

    // checking db if the username and email already exist or not
    $is_user_exist_query = "SELECT * FROM usersreg WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $is_user_exist_query);
    $user = mysqli_fetch_assoc($result);

    if ($user)
    { // if user exists
        if ($user['username'] === $username)
        {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email)
        {
            array_push($errors, "email id already exists");
        }
    }

    // If there are no errors then register the form values to the db
    if (count($errors) == 0)
    {
        $password = md5($password_1); //encrypting the password before saving in DB.
        $query = "INSERT INTO usersreg (username, password, email,firstname,lastname) 
  			  VALUES('$username', '$password', '$email','$firstname','$lastname')";
        mysqli_query($db, $query);
        //getting the id for uploading into file:
        $sql = "SELECT id FROM usersreg where username='$username'";
        $result = $db->query($sql);

        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $id = $row["id"];

            }
        }
        //uploading the file to the upload folder
        if (move_uploaded_file($file, $destination))
        {
            $sql = "INSERT INTO files (id,name, size, download,words) VALUES ('$id','$filename', $size, 0,0)";
            if (mysqli_query($db, $sql))
            {
                echo "File uploaded successfully";
            }
            // intializing counter for counting the number of words.
            $counter = 0;

            $fh = fopen("uploads/$filename", "r");

            while (!feof($fh))
            {
                if ($s = fgets($fh))
                {
                    $totalWords = preg_split('/\s+/', $s, -1, PREG_SPLIT_NO_EMPTY);
                    foreach ($totalWords as $word)
                    {
                        $counter++;
                    }
                }
            }
            /*
            while (($line = fgets($file1)) !== false)
            {
            
                $words = explode(" ", $line);
            
                $counter = $counter + count($words);
            }
            */
            fclose($fh);
            $sql1 = "update files SET  words=$counter where id=$id";
            if (mysqli_query($db, $sql1))
            {
                echo "Record updated success";
            }

        }
        else
        {
            echo "Failed to upload file.";
        }
        $_SESSION['id'] = $id;
        $_SESSION['counter'] = $counter;
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";

        header('location: home.php');
    }
}
// login page validation
if (isset($_POST['user_login']))
{
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username))
    {
        array_push($errors, "Username is required");
    }
    if (empty($password))
    {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0)
    {
        $password = md5($password);
        $query = "SELECT * FROM usersreg WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        // if row found then store in session variable
        if (mysqli_num_rows($results) == 1)
        {
            $_SESSION['id'] = $id;
            $_SESSION['counter'] = $counter;
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in !";

            header('location: home.php');
        }
        else
        {
            array_push($errors, "Wrong combination of username/password");
        }
    }
}

?>

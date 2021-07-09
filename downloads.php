<?php
session_start();
//getting the details of file to download
$id=$_SESSION['id'];
 $sql2 = "SELECT * from files  where id=$id";
        $conn2 = new mysqli('localhost', 'root', 'cloud09', 'custRegistration');
		$result2 = mysqli_query($conn2, $sql2);

		$file = mysqli_fetch_assoc($result2);
       $filepath = 'uploads/' . $file['name'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('uploads/' . $file['name']));
        readfile('uploads/' . $file['name']);
		// Now update downloads count
        $Counter = $file['download'] + 1;
        $updateQuery = "UPDATE files SET download=$Counter WHERE id=$id";
        mysqli_query($conn2, $updateQuery);
        exit;
        
    }
	
	?>
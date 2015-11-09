<?php session_start(); ?>
<html>
<head><title>Image Upload App</title>
</head>
<body>
<form enctype="multipart/form-data" action="results.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
Send this file: <input name="userfile" type="file" /><br />
Enter username: <input type="uname" name="uname" /><br />
Enter Email of user: <input type="email" name="useremail"><br />
Enter phone of user: (1-XXX-XXXX): <input type="phone" name="phone">

<input type="submit" value="Submit File" />
</form>
<hr />
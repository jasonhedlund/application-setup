<html>
<head><title>Gallery</title>
</head>
<body>

#!/usr/bin/php

<?php
session_start();
$email = $_SESSION['email'];

require 'vendor/autoload.php';

$rds = new Aws\Rds\RdsClinet::factory(array(
'region'  => 'us-east-1'
'version' => 'latest'
));

$result = $rds->describeDBInstances(array(
    'DBInstanceIdentifier' => 'mp1jphdb',
));

$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];

$link = mysqli_connect($endpoint,"jhedlund","letmeinplease","mp1jphdb") or die("Error " . mysqli_error($link));

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
'
$link->real_query("SELECT * FROM PERSON WHERE email = '$email'");

$res = $link->use_results();

while($row = $res->fetch_assoc()){

printf("\n");
echo "<img src=\ " " .$row['finishedurl'] . "\" />";
printf("\n");
}

$link->close();
?>
</body>
</html>

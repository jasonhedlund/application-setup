<html>
<head><title>Gallery</title>
</head>
<body>

<?php
session_start();
$email = $_POST['useremail'];

require 'vendor/autoload.php';

$rds = new Aws\Rds\RdsClinet([
'region'  => 'us-east-1'
'version' => 'latest'
]);

$result = $rds->describeDBInstances([
    'DBInstanceIdentifier' => 'mp1jphdb',
]);

$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];

$link = mysqli_connect($endpoint,"jhedlund","letmeinplease","mp1jphdb") or die("Error " . mysqli_error($link));

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

mysqli_query($link, "SELECT * FROM PERSON WHERE email = $'email'");

$results = $link->insert_id;

while($row = $res->fetch_assoc()){

printf("\n");
echo $row['useremail'];
echo '<img src="'.$row['s3rawurl'].'" width="200" height="200" />';
printf("\n");
}

$link->close();
?>
</body>
</html>

<html>
<head><title>Submit</title>
</head>
<body>

<?php 

session_start();

echo $_POST['useremail']

$uploaddir = '/tmp'
$uploadfile = $uploaddir . basename($_FILES['userfile']['name'];
$filename = $_FILES['userfile']['name'];
echo '<pre>';

if (move_uploaded_files($_FILES['userfile']['tmp_name'], $uploadfile)) {

echo -e "File is valid, and was successfully uploaded.\n"

}

else {

echo -e "Possible file upload attack!\n"

}

echo 'Here is some debugging info:' ;
print_r($_FILES);

print "</pre>";

require 'vendor/autoload.php';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

$bucket = uniqueid("php-jph-",false);

$result = $s3->createBucket([

'ACL' => 'public-read-write',
'Bucket' => $bucket,
]);

print_r($result);

$result = s3->putObject([
	'ACL' => 'public-read-write',
	'Bucket' => $bucket,
	'Key' => $uploadfile,
	'SourceFile' => $uploadfile,
]);

$url = $result['ObjectURL'];
echo $url;

$rds = new Aws\Rds\RdsClient([
'region' => 'us-east-1'
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

$email = $_POST['useremail'];
$phone = $_POST['phone'];
$s3rawurl = $url;
$filename = basename($_FILES['userfile']['name']);
$s3finishedurl = "none";
$state = 0;

mysqli_query($link, INSERT INTO PERSON (id,uname,email,phone,filename,s3rawurl,s3finishedurl,state,datetime) VALUES (NULL, '$uname', $'email', $'$phone', $'filename', $'s3rawurl', $'s3finishedurl', $'state', NULL)");

$results = $link->insert_id;

echo $link->error;

echo $results;

$link->close();

header('Location: gallery.php');

?>

</body>
</html>

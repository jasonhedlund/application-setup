<?php session_start();

echo $_POST['useremail']

$uploaddir = '/tmp'
$uploadfile = $uploaddir . basename($_FILES['userfile']['name'];

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

$client = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

$bucket = uniqueid("php-jph-",false);

$result = $client->putObject(array(

'Bucket' => $bucket
));

$client -> waitUntilBucketExists(array('Bucket' => $bucket));

$key = $uploadfile;

$result = $client->putObject(array(

'ACL' => 'public-read',
'Bucket' => $bucket,
'Key' => $key,
'SourceFile' => $uploadfile
);

$url = $result['ObjectURL'];
echo $url;

use AWS\Rds\RdsClient;
$client = RdsClient::factory(array(
'region' => 'us-east-1'
'version' => 'latest'
));

$result = $client->describeDBInstances(array(
'DBInstanceIdentifier' => 'mp1jphdb',
));

$endpoint = "";

foreach ($result->getPath('DBInstances/*/Endpoint/Address') as $ep) {

echo "============". $ep . "================";

$endpoint = $ep;

}

$link = mysqli_connect($endpoint,"jhedlund","letmeinplease","mp1jphdb") or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($stmt = $link->prepare("INSERT INTO userinfo (id,email,phone,filename,s3rawurl,s3finishedurl,state,timestamp) VALUES (NULL,?,?,?,?,?,?,?)")))
{

echo "Prepare failed: (" . $link->errno . ") " . $link->error;

}

$email = $_POST['useremail'];
$phone = $_POST['phone'];
$s3rawurl = $url;
$filename = basename($_FILES['userfile']['name']);
$s3finishedurl = "none";
$state = 0;
$timestamp = 0;

$smst->bind_param("sssssiii",$email,$phone,$filename,$s3rawurl,$s3finishedurl,$state,$timestamp);

if (!$smst->execute() {

echo "Execute failed: (" . $smst->errno . ") " . $smst->error;

}

printf("%d Row inserted.\n , $stmt->affected_rows);

$smgt->close();

$link->real_query("SELECT * FROM userinfo")
$res = $link->use result();

echo -e "Result set order.....\n";

while ($row = $res->fetch_assoc()){

echo $row['id'] . " " . $row['email']. " " . $row['phone'];
}

$link->close();

?>


<?php 

session_start();

echo $_POST['email'];

$uploaddir = '/tmp';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
echo '<pre>';

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

echo -e "File is valid, and was successfully uploaded.\n";

}

else {

echo -e "Possible file upload attack!\n";

}

echo 'Here is some debugging info:' ;
print_r($_FILES);

print "</pre>";

require 'vendor/autoload.php';

use Aws\S3\S3Client;

$client = S3Client::factory(array(
'version' => 'latest',
'region' => 'us-east-1'
));

$bucket = uniqid("php-jph-",false);

$result = $client->createBucket(array(
'ACL' => 'public-read-write',
'Bucket' => $bucket
));

$client->waitUntil('BucketExists', array(
'Bucket' => $bucket
));

$key = $uploadfile;

$result = $client->putObject(array(
	'ACL' => 'public-read-write',
	'Bucket' => $bucket,
	'Key' => $key,
	'SourceFile' => $uploadfile,
));

$url = $result['ObjectURL'];
echo $url;

$imagemagick = new Imagick ($uploadfile);
$imagemagick = thumbnailImage(50,50);
$imagemagick = writeImage($uploadfile);

$thumbnail = $client->PutObject(array(
	'ACL' => 'public-read-write',
	'Bucket' => $bucket,
	'Key' => "Thumbnail".$uploadfile,
	'Sourcefile' => $uploadfile
));

$finishedurl = $thumbnail

use Aws\Rds\RdsClient;

$client = RdsClient::factory(array(
'region' => 'us-east-1',
'version' => 'latest'
));

$result = $client->describeDBInstances(array(
'DBInstanceIdentifier' => 'mp1jphdb',
));

$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];

$link = mysqli_connect($endpoint,"jhedlund","letmeinplease","mp1jphdb") or die("Error " . mysqli_error($link));

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();

if (!($stmt = $link->prepare("INSERT INTO PERSON (uname,email,phone,filename,s3rawurl,s3finishedurl,state,datetime) VALUES (?,?,?,?,?,?,?,?)"))){

echo "Prepare failed: (" . $link->errno . ") " . $link->error:
}

$uname= $_POST['uname'];
$email= $_POST['email'];
$phone= $_POST['phone'];
$s3rawurl = $url;
$s3finishedurl = $finishedurl;
$filename = basename($_FILES['userfile']['name'];
$state = 0;
$datetime = now(;

$stmt->bind_param("sssssiii",$uname,$email,$phone,$s3rawurl,$s3finishedurl,$filename,$state,$datetime);

if (!stmt->execute()){

echo "Execute failed : (" . $stmt->errno . ") " . $stmt->error;

}

printf("%d Rows inserted.\n", $stmt->affected_rows);

$stmt->close();

$link->real_query("SELECT * FROM PERSON");

$res = $link->use_result();

echo -e "Results set in order...\n";

while ($row = $res->fetch_assoc()){

echo $row['id'] . " " . $row['email']. " " . $row['phone'];
}

use Aws\Sns\SnsClient;
$sns = new Aws\Sns\SnsClient(array(
'version' => 'latest',
'region' => 'us-east-1',
'credentials' => [
'key'    => '',
'secret' => '',
]
));

$result = $sns->createTopic(array(
    'Name' => 'SNSJPH',
));

$snsARN = $result['TopicArn'];

$resultsns = $sns->subscribe (array(
'Endpoint' => $email,
'Protocol' => 'email',
'TopicArn' => $snsARN,
));

$result = $sns->publish(array(
	'Message' => 'File has been successfully uploaded from this email address',
	'Subject' => 'S3 Bucket Image',    
	'TopicArn' => $snsARN,
));

$link->close();

?>
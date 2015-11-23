<?php

require 'vendor/autoload.php';

use Aws\Rds\RdsClient;

$client = RdsClient::factory(array(
'region'  => 'us-east-1',
'version' => 'latest'
));


$result = $client->describeDBInstances(array(
    'DBInstanceIdentifier' => 'mp1jphdb'
));


$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];

echo "begin database";
$link = mysqli_connect($endpoint,"jhedlund","letmeinplease","mp1jphdb") or die("Error " . mysqli_error($link));

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$create_table = 'CREATE TABLE PERSON
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    uname VARCHAR(20),
    email VARCHAR(200),
    phone VARCHAR(20),
    filename VARCHAR(255),
    s3rawurl VARCHAR(255),
    s3finishedurl VARCHAR(255),
    state TINYINT(3) CHECK(STATE IN(0,1,2)),
    datetime TIMESTAMP)")';

$create_tbl = $link->query($create_table);

if ($create_tbl) {
	echo "Table is created or No error returned.";
}
else {
        echo "error!!";  
}

$link->close();

$output="shell_exec("sudo chmod 600 setup.php");

?>

<?

// uncomment this line to use the production db:
// $m = new Mongo("mongodb://squaretestuser:squaretestpassword@ds045948.mongolab.com:45948/squaretestdb");

// this is the test db:
$m = new Mongo("mongodb://localhost");


if ( !$m.$connected ) {
 echo "Error connecting to the db: check config/env.php<br>"; 
}

$db = $m->selectDB('squaretestdb');
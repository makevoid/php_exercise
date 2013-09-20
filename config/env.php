<?

// mongodb://squaretestuser:squaretestpassword@ds045948.mongolab.com:45948/squaretestdb


$m = new Mongo("mongodb://squaretestuser:squaretestpassword@ds045948.mongolab.com:45948/squaretestdb");

var_dump($m);
// $db = $m->selectDB('my_database');
// $db->authenticate("my_login", "my_password");
$collection = new MongoCollection($db, 'my_collection');
$cursor = $collection->find();
foreach ($cursor as $doc) { var_dump($doc); }
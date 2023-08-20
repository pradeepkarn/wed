<?php
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/settings.php");
import("/includes/class-autoload.inc.php");
import("functions.php");
import("settings.php");
define("direct_access", 1);
###########################################################################

$dd = new Dummy_data;
$data = $dd->generate_user();

print_r($data);
exit;

$db = new Dbobjects;
$db->conn->beginTransaction();
$db->tableName = 'genre';
$db->insertData['genre'] = 'fiction';
$db->insertData['content_group'] = 'novel';
$db->filter($db->insertData);
//$db->delete();
$db->conn->rollBack();
//$db->conn->commit();



// print_r($data);
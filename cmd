<?php
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/settings.php");
import("/includes/class-autoload.inc.php");
import("functions.php");
import("settings.php");
define("direct_access", 1);
###########################################################################
// exit;
$dd = new Dummy_data;
$db = new Dbobjects;
$db->conn->beginTransaction();
$db->tableName = 'pk_user';
try {
    $user_num = 100;
    for ($i = 0; $i < $user_num; $i++) {
        $db->insertData = arr($dd->generate_user());
        $db->create();
        updateProgressBar($i, $totalIterations=$user_num);
    }
    $db->conn->commit();
} catch (PDOException $th) {
    $db->conn->rollBack();
}

function updateProgressBar($current, $total)
{
    $percent = ($current / $total) * 100;
    $barWidth = 50;
    $numBars = (int) ($percent / (100 / $barWidth));
    $progressBar = "[" . str_repeat("=", $numBars) . str_repeat(" ", $barWidth - $numBars) . "] $percent%";
    echo "\r$progressBar";
    // flush();
}


echo "\nTask complete!\n";

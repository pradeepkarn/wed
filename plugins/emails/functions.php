<?php

use League\Csv\Reader;

function import_csv($file)
{
  set_time_limit(500);
  // $file = MEDIA_ROOT."docs/test.csv";
  $csv = Reader::createFromPath($file, 'r');
  $csv->setHeaderOffset(0);

  $input_bom = $csv->getInputBOM();

  if ($input_bom === Reader::BOM_UTF16_LE || $input_bom === Reader::BOM_UTF16_BE) {
    $csv->addStreamFilter('convert.iconv.UTF-16/UTF-8');
  }
  worklog($msg="============== Task Start ===============");
  foreach ($csv as $key => $record) {
    $emails = new Model('emails');
    try {
      if ($emails->exists(array('email'=>$record['email']))==false) {
          // myprint($record['email']);
        $id = $emails->store($record);
        if (intval($id) && $id>0) {
          $msg = "| $key Success: {$record['email']} imported successfully";
        }else{
          $msg = "| $key Failed: {$record['email']} not imported";
        }
        worklog($msg);
      }else{
        $msg = "| $key Failed: {$record['email']} already existed";
        worklog($msg);
      }
    } catch (\Throwable $th) {
      $err = "| $key Error: $th";
      worklog($err);
    }
    echo $msg."<br>";
  }
  worklog($msg="================== End ==================\n");
  return;
}

function csv_heading($file)
{
  // $file = MEDIA_ROOT."docs/test.csv";
  $csv = Reader::createFromPath($file, 'r');
  $csv->setHeaderOffset(0);

  $input_bom = $csv->getInputBOM();

  if ($input_bom === Reader::BOM_UTF16_LE || $input_bom === Reader::BOM_UTF16_BE) {
    $csv->addStreamFilter('convert.iconv.UTF-16/UTF-8');
  }
 
  foreach ($csv as $key => $record) {
    return $record;
  }
}

function worklog($msg="")
{
  $file = MEDIA_ROOT."docs/import.log";
  $log_file = fopen($file, 'a');
  $message = date('Y-m-d H:i:s') . " $msg\n";
  fwrite($log_file, $message);
  fclose($log_file);
}

function verifyArrayKeys($array, $keys) {
  foreach ($keys as $key) {
      if (!array_key_exists($key, $array)) {
          return false;
      }
  }
  return true;
}
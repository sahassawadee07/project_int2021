<?php
 //get the index
 $index = $_GET['index'];
 
 //fetch data from json
 $json_string = file_get_contents('jobs.json');
 $data = json_decode($json_string, true);
 
 //delete the row with the index
 unset($data['jobs'][$index]);
 
 //encode back to json
 $data = json_encode($data, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE);
 file_put_contents('jobs.json', $data);
 
 header('location: Index_data.php');
?>

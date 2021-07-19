<?php

$jsonString = file_get_contents('jobs.json');
$data = json_decode($jsonString, true);

foreach ($data['jobs'] as $item){
echo $item ['dremio_space_name'];
// echo $item ['package_url'];
// echo $item ['api_key'];
// echo $item ['import_type'];
// echo $item ['file_name'];
// echo $item ['id'];
// echo $item ['resource_name'];
// echo $item ['description'];
}
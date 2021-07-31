<!DOCTYPE html>
<html>
<head>
    <title>แบบฟอร์มนำเข้าข้อมูล</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
<h2>แบบฟอร์มนำเข้าข้อมูล</h2>
<form action="Add_data.php" method="POST">
    <a href="Index_data.php">Back</a><br></br>
    Dremio Space Name: <input type="text" name="dremio_space_name" required><br><br>
    Package URL: <input type="text" name="package_url" required><br><br>
    API key: <input type="text" name="api_key" required><br><br>
    Import Type:
        <select name="import_type" id="importtype">
            <option value="new">new</option>
            <option selected="selected" value="update">update</option>
        </select>
    <br><br>
    File Name: <input type="text" name="file_name" required><br><br>
    Resource Meta<br><br>
    <div class="id" id="id">
        <label>ID:</label>
        <input type="text" class="id" name="id">
        </div><br><br>
    Name: <input type="text" name="resource_name" required><br><br>
    Description: <textarea name="description" required></textarea><br><br>
    <input type="submit" name="api_send" value="SEND" required><br><br>
</form>

<script>
    //--- setting when select difference import type ---
    $("#importtype").change(function(){
        if ($(this).val()=="new"){
            $("#id").hide().prop("disabled", true, this.checked);
        }
        else {
            $("#id").show().prop("disabled", false, this.checked);
        }
    });
</script>


<?php
//append the input to our array

$resource_meta = array(
    'id' => $id,
    'resource_name' => $resource_name, 
    'description' => $description
);
if ($import_type == 'new'){
    unset($resource_meta['id']);
}


$jobs = array('jobs' => array());
$array_job_details = array('dremio_space_name' => $dremio_space_name,
    'package_url' => $package_url,
    'api_key' => $api_key, 
    'import_type' => $import_type, 
    'file_name'=>$file_name, 
    'resource_meta' => $resource_meta
);

$jobs ['jobs'][]= $array_job_details;

//---- managing data ----
if(!empty($_POST['api_send'])){
    $project = array(
        'jobs' => array()
    );
     $int = 0;
    $jsonfile = "jobs2.json";
    if (file_exists($jsonfile)) {
        $fgc = file_get_contents($jsonfile); //open the json file
        $fgc = json_decode($fgc, true);

        foreach($fgc['jobs'] as $item){
            $project['jobs'][$int] = $item;
            $int++;
        }
     }
     //data in out POST
     $project['jobs'][$int]['dremio_space_name'] = isset($_POST['dremio_space_name'])?$_POST['dremio_space_name']:null;
     $project['jobs'][$int]['package_url'] = isset($_POST['package_url'])?$_POST['package_url']:null;
     $project['jobs'][$int]['api_key'] = isset($_POST['api_key'])?$_POST['api_key']:null;
     $project['jobs'][$int]['import_type'] = isset($_POST['import_type'])?$_POST['import_type']:null;
     $project['jobs'][$int]['file_name'] = isset($_POST['file_name'])?$_POST['file_name']:null;
     if ($_POST['import_type'] == 'update') {
        $project['jobs'][$int]['resource_meta']['id'] = isset($_POST['id'])?$_POST['id']:null;
     }
     $project['jobs'][$int]['resource_meta']['resource_name'] = isset($_POST['resource_name'])?$_POST['resource_name']:null;
     $project['jobs'][$int]['resource_meta']['description'] = isset($_POST['description'])?$_POST['description']:null;

     file_put_contents('jobs2.json', json_encode($project)); //encode back to json
     header('location: Index_data.php');
     //print_r($project);
 }
?>

</body>
</html>

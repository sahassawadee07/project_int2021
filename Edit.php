<?php


$_dremio_space_name = isset($_POST['dremio_space_name'])?$_POST['dremio_space_name']:null;
$_package_url = isset($_POST['package_url'])?$_POST['package_url']:null;
$_api_key = isset($_POST['api_key'])?$_POST['api_key']:null;
$_import_type = isset($_POST['import_type'])?$_POST['import_type']:null;
$_file_name = isset($_POST['file_name'])?$_POST['file_name']:null;
$_id = isset($_POST['id'])?$_POST['id']:null;
$_resource_name = isset($_POST['resource_name'])?$_POST['resource_name']:null;
$_description = isset($_POST['description'])?$_POST['description']:null;

$jsonString = file_get_contents('jobs.json');
$data = json_decode($jsonString, true);

//echo '<pre>';
//print_r($data['jobs'][0]['dremio_space_name']);
$dremio_space_name = $data['jobs'][0]['dremio_space_name'];
$package_url = $data['jobs'][0]['package_url'];
$api_key = $data['jobs'][0]['api_key'];
$import_type = $data['jobs'][0]['import_type'];
$file_name = $data['jobs'][0]['file_name'];
if ($import_type == 'update')
{
    $id = $data['jobs'][0]['resource_meta']['id'];
}
$resource_name = $data['jobs'][0]['resource_meta']['resource_name'];
$description = $data['jobs'][0]['resource_meta']['description'];
//echo '</pre>';


?>

<!doctype html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>


<body>
<h2>แบบฟอร์มนำเข้าข้อมูล</h2>
<form action="Edit.php" method="POST">
    Dremio Space Name: <input type="text" name="dremio_space_name" value="<?php echo isset($dremio_space_name)?$dremio_space_name:$_dremio_space_name; ?>" required><br><br>
    Package URL: <input type="text" name="package_url" value="<?php echo isset($package_url)?$package_url:$_package_url; ?>" required><br><br>
    API key: <input type="text" name="api_key"value="<?php echo isset($api_key)?$api_key:$_api_key; ?>" required><br><br>
    Import Type:
        <select name="import_type" id="importtype">
            <option value="new">new</option>
            <option selected="selected" value="update">update</option>
        </select>
    <br><br>
    File Name: <input type="text" name="file_name" value="<?php echo isset($file_name)?$file_name:$_file_name; ?>" required><br><br>
    Resource Meta<br><br>

    <div class="id" id="id" <?php echo ($import_type == 'update')?'':'style = "display:none"'; ?>>
        <label>ID:</label>
        <input type="text" class="id" name="id" value="<?php echo isset($id)?$id:$_id; ?>">
        </div><br><br>
    Name: <input type="text" name="resource_name" value="<?php echo isset($resource_name)?$resource_name:$_resource_name; ?>" required><br><br>
    Description: <textarea name="description" required><?php echo isset($description)?$description:$_description; ?></textarea><br><br>
    <input type="submit" value="UPDATE" name="api_update" required><br><br>
    

</form>

<script>
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

if(isset($_dremio_space_name)){
    echo "<h3>ข้อมูลที่รับเข้ามา</h3>";
    echo $_dremio_space_name;
    echo '<br>';
    echo $_package_url;
    echo '<br>';
    echo $_api_key;
    echo '<br>';
    echo $_import_type;
    echo '<br>';
    echo $_file_name;
    echo '<br>';
    echo $_id;
    echo '<br>';
    echo $_resource_name;
    echo '<br>';
    echo $_description;
}// End isset
else {
 echo "ไม่มีข้อมูล";
}


?><br><br>
<?php

print_r($_POST);

?><br><br>

<?php

$resource_meta = array(
    'id' => $_id,
    'resource_name' => $_resource_name, 
    'description' => $_description
);

if ($_import_type == 'new'){
    unset($resource_meta ['id']);
}
//----
$jobs = array('jobs' => array());
$array_job_details = array('dremio_space_name' => $_dremio_space_name,
    'package_url' => $_package_url,
    'api_key' => $_api_key, 
    'import_type' => $_import_type, 
    'file_name'=>$_file_name, 
    'resource_meta' => $resource_meta );

$jobs ['jobs'][]= $array_job_details;

if (isset($_POST['api_update']))
{
    $fp = fopen('jobs.json', 'w');
    fwrite($fp, json_encode($jobs, JSON_PRETTY_PRINT));
    fclose($fp);
    header('location:Edit.php');
}
echo json_encode($jobs);

?>
</body>
</html>
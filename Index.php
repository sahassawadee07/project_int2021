<?php

$dremio_space_name = isset($_POST['dremio_space_name'])?$_POST['dremio_space_name']:null;
$package_url = isset($_POST['package_url'])?$_POST['package_url']:null;
$api_key = isset($_POST['api_key'])?$_POST['api_key']:null;
$import_type = isset($_POST['import_type'])?$_POST['import_type']:null;
$file_name = isset($_POST['file_name'])?$_POST['file_name']:null;
$id = isset($_POST['id'])?$_POST['id']:null;
$resource_name = isset($_POST['resource_name'])?$_POST['resource_name']:null;
$description = isset($_POST['description'])?$_POST['description']:null;

//$jsonString = file_get_contents('results.json');
//$data = json_decode($jsonString, true);

?>

<!doctype html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>


<body>
<h2>แบบฟอร์มนำเข้าข้อมูล</h2>
<form action="Index.php" method="POST">
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
    <a href="http://127.0.0.1/project2021/Edit.php"><input type="button" value="แก้ไข"></a>
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

if(isset($dremio_space_name)){
    echo "<h3>ข้อมูลที่รับเข้ามา</h3>";
    echo $dremio_space_name;
    echo '<br>';
    echo $package_url;
    echo '<br>';
    echo $api_key;
    echo '<br>';
    echo $import_type;
    echo '<br>';
    echo $file_name;
    echo '<br>';
    echo $id;
    echo '<br>';
    echo $resource_name;
    echo '<br>';
    echo $description;
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

if (isset($_POST['api_send']))
{
    $fp = fopen('jobs.json', 'w');
    fwrite($fp, json_encode($jobs, JSON_PRETTY_PRINT));
    fclose($fp);
}
echo json_encode($jobs);


?>
</body>
</html>
<?php 
//------------- Get the index -------------
$index = isset($_GET['index'])?$_GET['index']:null;
    
$_dremio_space_name = isset($_POST['dremio_space_name'])?$_POST['dremio_space_name']:null;
$_package_url = isset($_POST['package_url'])?$_POST['package_url']:null;
$_api_key = isset($_POST['api_key'])?$_POST['api_key']:null;
$_import_type = isset($_POST['import_type'])?$_POST['import_type']:null;
$_file_name = isset($_POST['file_name'])?$_POST['file_name']:null;
$_id = isset($_POST['id'])?$_POST['id']:null;
$_resource_name = isset($_POST['resource_name'])?$_POST['resource_name']:null;
$_description = isset($_POST['description'])?$_POST['description']:null;

//-------- get json data -----------
$jsonString = file_get_contents('jobs.json');
$data = json_decode($jsonString, true);

//-------- assign the data to selected index ---------
if(!empty($index) || $index == '0'){
    $dremio_space_name = $data['jobs'][$index]['dremio_space_name'];
    $package_url = $data['jobs'][$index]['package_url'];
    $api_key = $data['jobs'][$index]['api_key'];
    $import_type = $data['jobs'][$index]['import_type'];
    $file_name = $data['jobs'][$index]['file_name'];
    if ($import_type == 'update')
    {
        $id = $data['jobs'][$index]['resource_meta']['id'];
    }
    $resource_name = $data['jobs'][$index]['resource_meta']['resource_name'];
    $description = $data['jobs'][$index]['resource_meta']['description'];
}
        //echo $index;
//--------
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>แบบฟอร์มนำเข้าข้อมูล</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/headers/">
    <!-- Bootstrap core CSS -->
    <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a  class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
        <span class="fs-1">Edit Data</span>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link">Back to the table data page </a></li>
        <li class="nav-item"><a href="Index_data.php" class="nav-link active" aria-current="page">Back</a></li>
      </ul>
    </header>
    </div>
</head>


<body>

<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-7">

<form action="Edit_data.php?index=<?php echo $index ?>" method="POST">
<link href="form-validation.css" rel="stylesheet">
  <body class="bg-light">
  <div class="container">
  <h4 class="mb-3">Form</h4>
    Dremio Space Name: <input type="text" class="form-control" name="dremio_space_name" value="<?php echo isset($dremio_space_name)?$dremio_space_name:$_dremio_space_name; ?>" required><br>
    Package URL: <input type="text" class="form-control" name="package_url" value="<?php echo isset($package_url)?$package_url:$_package_url; ?>" required><br>
    API key: <input type="text" class="form-control" name="api_key"value="<?php echo isset($api_key)?$api_key:$_api_key; ?>" required><br>
    Import Type:
        <select class="form-select" name="import_type" id="importtype">
            <option value="new">new</option>
            <option selected="selected" value="update">update</option>
        </select>
    <br>
    File Name: <input type="text" class="form-control" name="file_name" value="<?php echo isset($file_name)?$file_name:$_file_name; ?>" required><br>
    <hr class="my-4">
    <h4 class="mb-3">Resource Meta</h4>
    <div class="row gy-3">
    <div class="col-md-6">
        <div class="id" class="form-control" id="id" <?php echo ($_import_type == 'update')?'':'style = "display:none"'; ?>>
            <label>ID:</label>
            <input type="text" class="id" class="form-control" name="id" value="<?php echo isset($id)?$id:$_id; ?>">
        </div><br>
    </div>
    <div class="col-md-6">
        Name: <input type="text" class="form-control" name="resource_name" value="<?php echo isset($resource_name)?$resource_name:$_resource_name; ?>" required><br>
    </div>   
    Description: <textarea class="form-control" name="description" required><?php echo isset($description)?$description:$_description; ?></textarea><br>
    <input type="submit" class="btn btn-success" value="UPDATE" name="api_update" required><br>

</form>
        </div>
    </div>
</div>

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
    'id' => $_id,
    'resource_name' => $_resource_name, 
    'description' => $_description
);

if ($_import_type == 'new'){
    unset($resource_meta ['id']);
}

$jobs = array('jobs' => array());
$array_job_details = array('dremio_space_name' => $_dremio_space_name,
    'package_url' => $_package_url,
    'api_key' => $_api_key, 
    'import_type' => $_import_type, 
    'file_name'=>$_file_name, 
    'resource_meta' => $resource_meta );

$jobs ['jobs'][]= $array_job_details;
?>

<?php
if(!empty($_POST)){
    $project = '';
    //get the index from URL
 
    $int = 0;
    $jsonfile = "jobs.json";
    if (file_exists($jsonfile)) {
        $fgc = file_get_contents($jsonfile);
        $fgc = json_decode($fgc, true);

     }
     $project = $fgc;
     $project['jobs'][$index]['dremio_space_name'] = isset($_POST['dremio_space_name'])?$_POST['dremio_space_name']:null;
     $project['jobs'][$index]['package_url'] = isset($_POST['package_url'])?$_POST['package_url']:null;
     $project['jobs'][$index]['api_key'] = isset($_POST['api_key'])?$_POST['api_key']:null;
     $project['jobs'][$index]['import_type'] = isset($_POST['import_type'])?$_POST['import_type']:null;
     $project['jobs'][$index]['file_name'] = isset($_POST['file_name'])?$_POST['file_name']:null;
     if ($_POST['import_type'] == 'update') {
        $project['jobs'][$index]['resource_meta']['id'] = isset($_POST['id'])?$_POST['id']:null;
     }
     $project['jobs'][$index]['resource_meta']['resource_name'] = isset($_POST['resource_name'])?$_POST['resource_name']:null;
     $project['jobs'][$index]['resource_meta']['description'] = isset($_POST['description'])?$_POST['description']:null;
    

    if (isset($_POST['api_update']))
    {
     file_put_contents('jobs.json', json_encode($project, JSON_UNESCAPED_UNICODE));
     header('location:Index_data.php');
    }
     
 }
?>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>แบบฟอร์มนำเข้าข้อมูล</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<a href="Add_data.php">Add</a>
<table class="table table-hover">
	<thead>
        <th>Dremio Space Name</th>
        <th>Package URL</th>
        <th>API Key</th>
        <th>Import Type</th>
        <th>File Name</th>
        <th>ID</th>
        <th>Resource Name</th>
        <th>Description</th>
		<th>Action</th>
	</thead>
	<tbody>
		<?php
			//fetch data from json
			$json_string = file_get_contents('jobs2.json');
			//decode into php array
			$data = json_decode($json_string, true);
 
			$index = 0;
			foreach($data['jobs'] as $item):?>
            <tr>
                <td><?php echo $item['dremio_space_name']; ?></td>
                <td><?php echo $item['package_url']; ?></td>
                <td><?php echo $item['api_key']; ?></td>
                <td><?php echo $item['import_type']; ?></td>
                <td><?php echo $item['file_name']; ?></td>
                <td><?php echo ($item['import_type'] == 'update')?$item['resource_meta']['id']:''; ?></td>
                <td><?php echo $item['resource_meta']['resource_name']; ?></td>
                <td><?php echo $item['resource_meta']['description']; ?></td>
                <td><?php echo "
                    <a href='Edit_data.php?index=".$index."' class=\"btn btn-warning\">Edit</a>
                    <a href='Delete_data.php?index=".$index."' class='btn btn-danger'>Delete</a>
                    ";?></td>
            </tr>
        <?php $index++;?>
        <?php endforeach; ?>
	</tbody>
</table>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>

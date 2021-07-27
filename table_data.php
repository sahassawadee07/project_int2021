<?php
$json_string = file_get_contents('jobs2.json');
$data = json_decode($json_string, true);

?>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Dremio Space Name</th>
            <th>Package URL</th>
            <th>API Key</th>
            <th>Import Type</th>
            <th>File Name</th>
            <th>ID</th>
            <th>Resource Name</th>
            <th>Description</th>
        </tr>
    </thead>
    
    <tbody>
    <?php foreach($data['jobs'] as $item): ?>
        <tr>
            <td><?php echo $item['dremio_space_name']; ?></td>
            <td><?php echo $item['package_url']; ?></td>
            <td><?php echo $item['api_key']; ?></td>
            <td><?php echo $item['import_type']; ?></td>
            <td><?php echo $item['file_name']; ?></td>
            <td><?php echo ($item['import_type'] == 'update')?$item['resource_meta']['id']:''; ?></td>
            <td><?php echo $item['resource_meta']['resource_name']; ?></td>
            <td><?php echo $item['resource_meta']['description']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
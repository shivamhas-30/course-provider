<?php
$json_data = file_get_contents('uploadfile.json');
$data = json_decode($json_data, true);
?>
<!DOCTYPE html>

    <title>Downloads</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>
</head> 
<body>
<h2 stylesheet="text-align:center">Downloads</h2>

<table>
    <tr>
        <th>Id</th>
        <th>Date</th>
        <th>File</th>
        <th>Download</th>
    </tr>
    <?php foreach ($data as $row) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['datetime'] . "</td>";
        echo "<td>" . $row['FileName'] . "</td>";
        echo "<td><a href='#' onclick=\"downloadFile('docs/" . $row['FileSave'] . "')\">Download</a></td>";
        echo "</tr>";
    }
    ?>
</table>

<script>
    function downloadFile(filePath) {
        var link = document.createElement('a');
        link.href = filePath;
        link.setAttribute('download', filePath.split('/').pop());
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
            
    }
</script>
</body>
</html>


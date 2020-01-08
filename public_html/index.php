<?php

require '../bootloader.php';
require ROOT . '/core/classes/FileDB.php';

$db = new \Core\FileDB('../app/data/db.txt');
$data_array = ['lol', 'rofl'];
$db->setData($data_array);
$db->save();

?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="media/css/normalize.css">
        <link rel="stylesheet" href="media/css/milligram.min.css">
        <link rel="stylesheet" href="media/css/style.css">		
        <title>OOP</title>
    </head>
    <body>
		<h1>Darome HIP, darome OOP</h1>
    </body>
</html>

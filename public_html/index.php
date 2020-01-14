<?php

require '../bootloader.php';

$user = new \App\Users\Users(
    [
        'username' => 'Testas',
        'email' => 'bamba@testas.bam',
        'password' => 'msalkdha',
        'timestamp' => time()
    ]
);
$user_second = new \App\Users\Users(
    [
        'username' => 'mazas',
        'email' => 'bamba@testas.bam',
        'password' => 'msalkdha',
        'timestamp' => time()
    ]
);

$db = new \App\Users\Model();
$db->insert($user);
$db->insert($user_second);

$conditions = [
        'username' => 'Testas',
    'email' => 'bamba@testas.bam'
];


var_dump($db->getRows('users', $conditions));

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

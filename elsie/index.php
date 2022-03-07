<?php
# Include Elsie Functions

require 'ElsieFiles/tasks.php';

$e_elsie_status = "Let's make a website.";

if (file_exists('../index.html')) {
    $e_elsie_status = "index.html already exists on server. You will need to rename this file or remove it before continuing.";
}   
else {
    elsie_code_website();
}

?>

<html>
<head>
<title>Elsie</title>
<style>
body{
background-color:#1f2f45;
color:#fff;
}
h1{
font-size:40px;
text-align:center;
}
h2{
font-size:26px;
text-align:center;
}
p{
font-size:16px;
text-align:center;
}
</style>
</head>
<body>
<h1>Elsie</h1>
<h2><?php echo $e_elsie_status;?></h2>
</body>
</html>
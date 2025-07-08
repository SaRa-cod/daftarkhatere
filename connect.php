<?php
$db_name = 'mysql:host=localhost;dbname=daftar_db';
$user_name = 'root';
$user_password = '';
$conn = new PDO($db_name, $user_name, $user_password);
if (!$conn) {
echo "not connected to database";
}
function unique_id(){
$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charsLength = strlen($chars);
$randonString = '';
   for ($i=0; $i < 20; $i++) {
     $randonString.=$chars[mt_rand(0, $charsLength - 1)];
    }
   return $randonString;
}

?>
<?php
Include 'connect.php';
if (isset($_COOKIE['user_id'])) {
      $user_id = $_COOKIE['user_id'];}
  else{
      $user_id = '';
    }
   if (isset($_POST['login'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);


   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password =
      ? LIMIT 1");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if ($select_user->rowCount() > 0){
      setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
      header('location:home.php');
   }else{
      $warning_msg[] = '!آدرس ایمیل یا رمز عبور اشتباه است';
   }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- box icon cdn link-->
<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" type="text/css" href="user-style.css?v=<?php echo time(); ?>">
<title>daftarkhaterat</title>
   </head>
<body>
<div class="form-container form">
   <form action="" method="post" enctype="multipart/form-data" class="login">
      <h3>login</h3>

      <div class="input-field">
         <p>name</p><span ></span>
         <input type="email" name="email" placeholder="ایمیل خود را وارد کنید" maxlength="50" required class="box">
      </div>
      <div class="input-field">
         <p>password</p><span></span>
         <input type="password" name="pass" placeholder="رمز عبور" maxlength="50" required class="box">
      </div>

   <button type="submit" name="login" class="btn">login</button>
 </form>
</div>
</body>
</html>
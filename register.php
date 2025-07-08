<?php
Include 'connect.php';
   if (isset($_COOKIE['user_id'])) {
      $user_id = $_COOKIE['user_id'];}
  else{
      $user_id = '';
    }

    if (isset($_POST['register'])) {
   
   $id = unique_id();

   $name = $_POST['name'];
   $name = filter_var ($name, FILTER_SANITIZE_STRING);

   $email = $_POST['email'];
   $email = filter_var ($email, FILTER_SANITIZE_STRING);

   $pass = sha1 ($_POST['pass']);
   $pass = filter_var ($pass, FILTER_SANITIZE_STRING);

   $cpass = sha1 ($_POST['cpass']);
   $cpass = filter_var ($cpass, FILTER_SANITIZE_STRING);


   $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_users->execute([$email]);

   if ($select_users->rowCount() > 0) {
      $warning_msg[] = 'آدرس ایمیل از قبل وجود دارد';
   } else {
      if ($pass != $cpass) {
         $warning_msg[] = 'رمزعبور با تکرارش ملابقت ندارد';
      } else {
         $insert_users = $conn->prepare("INSERT INTO `users`(id, name, email, 
            password) VALUES(?,?,?,?)");
         $insert_users->execute([$id, $name, $email, $cpass]);

         $success_msg[] = '!کاربر عزیز حساب شما ایجاد شد لصقا از طریق صفحه ورود وارد شوید';
      }
      
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
<div class="form-container form ">
   <form action="" method="post" enctype="multipart/form-data" class="register">
      <h3>register</h3>
      <div class="flex">
         <div class="col">
            <div class="input-field">
               <p>name</p>
               <input type="text" name="name" placeholder="نام خود را وارد کنید" maxlength="50" required class="box">
            </div>
            <div class="input-field">
               <p>your email</p>
               <input type="email" name="email" placeholder="ایمیل خود را وارد کنید" maxlength="50" required class="box">
            </div>
         </div>
         <div class="col">
            <div class="input-field">
               <p>password</p>
               <input type="password" name="pass" placeholder="رمز عبور" maxlength="50" required class="box">
            </div>
            <div class="input-field">
               <p>repeat password </p>
               <input type="password" name="cpass" placeholder="تایید رمز عبور" maxlength="50" required class="box">
            </div>
         </div>
      </div>
   <p class="link">if you already have an account login from <a href="login.php">login page</a></p>
   <button type="submit" name="register" class="btn">register</button>
 </form>
</div>
</body>
</html>
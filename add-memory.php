<?php
Include 'connect.php';
   if (isset($_COOKIE['user_id'])) {
      $user_id = $_COOKIE['user_id'];}
  else{
      $user_id = ''; 
      header('location:login.php');
    }
    //save memory
    if (isset($_POST['publish'])) {
      $id = uniqid();

      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);

      $content = $_POST['content'];
      $content = filter_var($content, FILTER_SANITIZE_STRING);

      $category = $_POST['category'];
      $category = filter_var($category, FILTER_SANITIZE_STRING);

      $thumb_one = $_FILES['thumb_one']['name'];
      $thumb_one = filter_var($thumb_one, FILTER_SANITIZE_STRING);
      $thumb_one_tmp_name = $_FILES['thumb_one']['tmp_name'];
      $thumb_one_folder = 'uploaded_files/'.$thumb_one;

      $insert_memory = $conn->prepare("INSERT INTO `memory`(id, user_id, name, category, thumb_one, memory_detail) VALUES(?,?,?,?,?,?)");

      $insert_memory->execute([$id, $user_id, $name, $category, $thumb_one, $content]);

      move_uploaded_file($thumb_one_tmp_name, $thumb_one_folder);

      $success_msg[] = 'memory added';
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
  <div class="add_memory">
      <div class="heading">
          <h1>new diary</h1>
      </div>
      <div class="form-container">
          <form action="" method="post" enctype="multipart/form-data" class="register">
              <div class="flex">
                  <div class="col">
                      <div class="input-field">
                        <p>subject</p>
                        <input type="text" name="name" maxlength="100" placeholder="..." required class="box">
                      </div>
                  </div>
                  <div class="col">
                      <div class="input-field">
                        <p>photo<span></span></p>
                        <input type="file" name="thumb_one" accept="image/*" required class="box">
                      </div>
                  </div>
              </div>
              <div class="input-field">
                <p>diary type</p>
                <select name="category" required class="box">
                   <option disabled selected>select your diary type</option>
                   <option value="memory">memory</option>
                   <option value="note">note</option>
                </select>
              </div>
              <div class="input-field">
                  <p >textarea</p>
                  <textarea style="text-align:right;" class="box" name="content" required></textarea>
              </div>
              <div>
                  <button type="submit" name="publish" class="btn">add</button>
              </div>
          </form>
      </div>
  </div>
  <?php Include 'user-header.php'; ?>
</body>
</html>
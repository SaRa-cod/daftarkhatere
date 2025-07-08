<?php
Include 'connect.php';
   if (isset($_COOKIE['user_id'])) {
      $user_id = $_COOKIE['user_id'];}
  else{
      $user_id = '';
      header('location:login.php');
    }
    //update memory
    if (isset($_POST['update'])) {
      $memory_id = $_POST['memory_id'];
      $memory_id = filter_var($memory_id, FILTER_SANITIZE_STRING);

      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);

      $content = $_POST['content'];
      $content = filter_var($content, FILTER_SANITIZE_STRING);

      $category = $_POST['category'];
      $category = filter_var($category, FILTER_SANITIZE_STRING);


      $update_memory = $conn->prepare("UPDATE `memory` SET name = ?,category = ?,memory_detail = ? WHERE id = ?");
      $update_memory->execute([$name, $category, $content, $memory_id]);

      $success_msg[] = 'memory updated';

      $thumb_one = $_FILES['thumb_one']['name'];
      $thumb_one = filter_var($thumb_one, FILTER_SANITIZE_STRING);
      $thumb_one_tmp_name = $_FILES['thumb_one']['tmp_name'];
      $thumb_one_folder = 'uploaded_files/'.$thumb_one;


      $update_image = $conn->prepare("UPDATE `memory` SET thumb_one = ? WHERE id = ?");
      $update_image->execute([$thumb_one, $memory_id]);

      move_uploaded_file($thumb_one_tmp_name, $thumb_one_folder);

      $success_msg[] = 'memory image updated';
    }
    //delete memory

    if (isset($_POST['delete'])) {
         $p_id = $_POST['memory_id'];
         $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

         $delete_image = $conn->prepare("SELECT * FROM `memory` WHERE id = ?");
         $delete_image->execute([$p_id]);
         $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

         if ($fetch_delete_image['thumb_one'] != '') {
             unlink('uploaded_files/'.$fetch_delete_image['thumb_one']);
         }
         $delete_memory = $conn->prepare("DELETE FROM `memory` WHERE id = ?");
         $delete_memory->execute([$p_id]);
         header('location:view-memory.php');
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
  <div class="edit_memory">
      <div class="heading" style="margin-top:7rem;">
          <h1>edit diary</h1>
      </div>
      <div class="container">
        <?php
            $memory_id = $_GET['id'];
            $select_memory = $conn->prepare("SELECT * FROM `memory` WHERE id = ?");
            $select_memory->execute([$memory_id]);

            if ($select_memory->rowCount() > 0) {
                while ($fetch_memory = $select_memory->fetch(PDO::FETCH_ASSOC)) {


            ?>
            <div class="form-container">
          <form action="" method="post" enctype="multipart/form-data" class="register">
            <input type="hidden" name="memory_id" value="<?= $fetch_memory['id']; ?>">
              <div class="flex">
                  <div class="col">
                      <div class="input-field">
                        <p>subject<span></span></p>
                        <input type="text" name="name" maxlength="100" value="<?= $fetch_memory['name']; ?>" class="box">
                      </div>
                      <div class="input-field">
                <p>diary type<span></span></p>
                <select name="category" class="box">
                   <option selected value="<?= $fetch_memory['category']; ?>"><?= $fetch_memory['category']; ?></option>
                   <option value="memory">memory</option>
                   <option value="note">note</option>
                </select>
              </div>
                  </div>
                  <div class="col">
                      <div class="input-field">
                        <p>photo<span></span></p>
                        <input type="file" name="thumb_one" accept="image/*" class="box">
                      </div>
                      <div class="input-field">
              </div>
                  </div>
              </div>
              
              <div class="input-field">
                  <div class="flex-btn">
                    <img src="uploaded_files/<?= $fetch_memory['thumb_one']; ?>">
                  </div>
              </div>
              <div class="input-field">
                  <p>your text<span></span></p>
                  <textarea class="box" style="text-align:right;" name="content" required><?= $fetch_memory['memory_detail']; ?></textarea>
              </div>
              <div>
                  
                  <button type="submit" name="delete" onclick="return confirm('حذف کالا؟');" class="btn" style="width: 33%;text-align: center;">delete</button>
                  <button type="submit" name="update" class="btn" style="width: 33%;text-align: center;align-items: right;">update</button>

              </div>
          </form>
      </div>
  </div>
            <?php
          }
        }else{
                echo '
      <div class="empty">
         <p>no diary added yet! <br> <a href="add-memory.php" class="btn" style="margin-top="1rem>add new</a></p>
      </div>
      ';
            }

            ?>
        
      </div>
  </div>
  <?php Include 'user-header.php'; ?>
</body>
</html>
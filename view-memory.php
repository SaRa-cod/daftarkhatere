<?php
Include 'connect.php';
   if (isset($_COOKIE['user_id'])) {
      $user_id = $_COOKIE['user_id'];}
  else{
      $user_id = '';
      header('location:login.php');
    }
    //delete product from database
    if (isset($_POST['delete'])) {
         
         $p_id = $_POST['memory_id'];
         $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

         $delete_memory = $conn->prepare("DELETE FROM `memory` WHERE id = ?");
         $delete_memory->execute([$p_id]);

         $success_msg[] = 'memory delete successfully';
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
  <div class="view-memory">
      <div class="heading">
      </div>
      <div class="box-container">
        <?php
           $select_memory = $conn->prepare("SELECT * FROM `memory` WHERE user_id = ?");
           $select_memory->execute([$user_id]);

           if ($select_memory->rowCount() > 0) {
             while ($fetch_memory = $select_memory->fetch(PDO::FETCH_ASSOC)) {
               
        ?>
        <form action="" method="post" class="box">
          <input type="hidden" name="memory_id" value="<?= $fetch_memory['id']; ?>">
          <div class="icon">
              <div class="icon-box">
                  <img src="uploaded_files/<?= $fetch_memory['thumb_one']; ?>" class="img">
              </div>
              
          </div>
          <div class="content">
              <div class="title"><?= $fetch_memory['name']; ?></div>
              <div class="flex-btn">
                  <button type="submit" name="delete" onclick="return confirm('آیا از حذف اطمینان دارید؟');" class="btn">حذف</button>
                  <a href="read-memory.php?post_id=<?= $fetch_memory['id']; ?>" class="btn">مشاهده</a>
              </div>
          </div>
        </form>
        <?php
      }
    }else{
      echo '
      <div class="empty">
         <p>no memory added yet! <br> <a href="add-memory.php" class="btn" style="margin-top="1rem>add-new</a></p>
      </div>
      ';
    }
       ?> 
    </div>
  </div>
      
  <?php Include 'user-header.php'; ?>
</body>
</html>
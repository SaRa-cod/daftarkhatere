<?php
Include 'connect.php';
   if (isset($_COOKIE['user_id'])) {
      $user_id = $_COOKIE['user_id'];}
  else{
      $user_id = '';
      header('location:login.php');
    }
    //read memory
    $get_id = $_GET['post_id'];
    
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
  <div class="read_memory">
      <div class="heading">
        <br><br>
          <h1>مشاهده کالا</h1>
          <br>
      </div>
      <div class="container" style="text-align: center;">
        <?php
            $select_memory = $conn->prepare("SELECT * FROM `memory` WHERE id=?");
            $select_memory->execute([$get_id]);

            if ($select_memory->rowCount() > 0) {
                while ($fetch_memory = $select_memory->fetch(PDO::FETCH_ASSOC)) {
                
        ?>
    <form action="" method="post" class="box">
            <input type="hidden" name="memory_id" value="<?= $fetch_memory['id']; ?>">

        <div class="memory_slider">
                <div>
                <img class="slider-Image" src="uploaded_files/<?= $fetch_memory['thumb_one']; ?>">
                </div>
        </div>
        <div class="title"><?= $fetch_memory['name']; ?></div>
        <div class="content"><?= $fetch_memory['memory_detail']?></div>
        <div class="flex-btn">
            <a href="edit-memory.php?id=<?= $fetch_memory['id']; ?>" class="btn">ویرایش</a>
            <button type="submit" name="delete" onclick="return confirm('حذف کالا؟');" class="btn">حذف</button>
            
            
        </div>
        </form>
    
        <?php
                }
            }
        else{
                echo '
      <div class="empty">
         <p>no memory added yet! <br> <a href="add-memory.php" class="btn" style="margin-top="1rem>add new</a></p>
      </div>
      ';
            }
        ?>
            

      </div>
</div>
      
  <?php Include 'user-header.php'; ?>
</body>
</html>
<?php
Include 'connect.php';
   if (isset($_COOKIE['user_id'])) {
      $user_id = $_COOKIE['user_id'];}
  else{
      $user_id = '';
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
<body style="background-image: url(img/back11.jpg);background-size: cover;
    background-repeat: no-repeat;"> 
  <div class="dashboard">
   <div class="heading" style="margin-top: 7rem;">
      <h1>my diary</h1>
   </div>
<div class="box-container">
  <div class="box">
       <?php
           $select_memory = $conn->prepare("SELECT * FROM `memory` WHERE user_id = ?");
           $select_memory->execute([$user_id]);
           $num_of_memory = $select_memory->rowCount();
        ?>
        <h3>new diary</h3>
        <a href="add-memory.php" class="btn">add new</a>
  </div>
  <div class="box">
       <?php
           $select_memory = $conn->prepare("SELECT * FROM `memory` WHERE user_id = ?");
           $select_memory->execute([$user_id]);
           $num_of_memory = $select_memory->rowCount();
        ?>
        <h3><?= $num_of_memory ?></h3>
        <h4>all diary </h4>
        <a href="view-memory.php" class="btn">see all</a>
  </div>
</div>
<div class="box-container">
  <div class="box">
       <?php
           $select_note_memory = $conn->prepare("SELECT * FROM `memory` WHERE user_id = ? AND category = ?");
           $select_note_memory->execute([$user_id, 'note']);
           $num_of_note_memory = $select_note_memory->rowCount();
        ?>
        <h3><?= $num_of_note_memory ?></h3>
        <h4>notes</h4>
        <a href="notes.php" class="btn">see all</a>
  </div>
  <div class="box">
       <?php
           $select_memorys = $conn->prepare("SELECT * FROM `memory` WHERE user_id = ? AND category = ?");
           $select_memorys->execute([$user_id, 'memory']);
           $num_of_memorys = $select_memorys->rowCount();
        ?>
        <h3><?= $num_of_memorys ?></h3>
        <h4>memories</h4>
        <a href="memory.php" class="btn">see all</a>
  </div>
</div>
</div>
<?php Include 'user-header.php'; ?>

</body>
</html>
<link rel="stylesheet" type="text/css" href="user-style.css?v=<?php echo time(); ?>">
<header>
	<div class="right">
		<div class="bx bxs-user" id="user-btn"></div>
	</div>
	<div class="profile">
   <?php
       $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
       $select_profile->execute([$user_id]);
       if ($select_profile->rowCount() > 0) { 
       	   $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
   ?>
    
    <h3 style="margin-bottom: .5rem;"><?= $fetch_profile['name']; ?></h3>
    <div class="flex-btn">
        <a href="profile.php" class="btn">profile</a>
        <a href="login.php" onclick="return confirm('خروچ از حساب؟');" class="btn">logout</a>
 </div>
    <?php
      } ?>
</div>
</header>
<script type="text/javascript">
const userBtn = document.querySelector('#user-btn');
userBtn.addEventListener('click', function(){
    const userBox = document.querySelector('.profile');
    userBox.classList.toggle('active');
})
</script>

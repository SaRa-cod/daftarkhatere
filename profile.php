<?php
include 'connect.php';

if(isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id'])) {
    $current_user_id = $_COOKIE['user_id'];
} else {
    die('<div class="error">لطفاً ابتدا وارد شوید</div>');
}

if (isset($_POST['update'])) {
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_user->execute([$current_user_id]);
    $current_data = $select_user->fetch(PDO::FETCH_ASSOC);

    $name = !empty($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : $current_data['name'];
    $email = !empty($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : $current_data['email'];
    

    if($update_user->rowCount() > 0) {
        $success_msg[] = 'اطلاعات با موفقیت به روز شد';
        header("Refresh:0");
        exit();
    } else {
        $warning_msg[] = 'هیچ تغییری اعمال نشد';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="user-style.css?v=<?php echo time(); ?>">
    <title>daftarkhaterat</title>
</head>
<body>
    <?php include 'user-header.php'; ?>
    
    <div class="edit_memory">
        <div class="heading" style="margin-top:7rem;">
            <h1>ویرایش پروفایل</h1>
        </div>
        <div class="container">
            <?php
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_user->execute([$current_user_id]);

            if ($select_user->rowCount() > 0) {
                $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
            ?>
                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data" class="register">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($current_user_id); ?>">
                        <div class="flex">
                            <div class="col">
                                <div class="input-field">
                                    <p>new name</p>
                                    <input type="text" name="name" maxlength="100" 
                                           value="<?= htmlspecialchars($fetch_user['name'] ?? ''); ?>" class="box">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-field">
                                    <p>new email</p>
                                    <input type="email" name="email" maxlength="100" 
                                           value="<?= htmlspecialchars($fetch_user['email'] ?? ''); ?>" class="box">
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" name="update" class="btn" style="text-align: center;align-items: right;">
                             update
                            </button>
                        </div>
                    </form>
                </div>
            <?php
            } else {
                echo '<p class="error">اطلاعات کاربر یافت نشد</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>
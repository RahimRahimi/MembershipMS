<?php
    include('includes/config.php');

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['systemSettings'])) {
        $systemName = $_POST['systemName'];
        $currency = $_POST['currency'];

        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $logoName = $_FILES['logo']['name'];
            $logoTmpName = $_FILES['logo']['tmp_name'];
            $logoType = $_FILES['logo']['type'];
            $uploadPath = 'uploads/'; 

            $targetPath = $uploadPath . $logoName;
            if (move_uploaded_file($logoTmpName, $targetPath)) {
                $updateSettingsQuery = "UPDATE settings SET system_name = '$systemName', logo = '$targetPath', currency = '$currency' WHERE id = 1";
                $updateSettingsResult = $conn->query($updateSettingsQuery);

                if ($updateSettingsResult) {
                    $systemSuccess = 'System settings updated successfully.';
                } else {
                    $systemError = 'Error updating system settings: ' . $conn->error;
                }
            } else {
                $systemError = 'Error moving uploaded file.';
            }
        } else {
            $updateSettingsQuery = "UPDATE settings SET system_name = '$systemName', currency = '$currency' WHERE id = 1";
            $updateSettingsResult = $conn->query($updateSettingsQuery);
            if ($updateSettingsResult) {
                $systemSuccess = 'System settings updated successfully.';
            } else {
                $systemError = 'Error updating system settings: ' . $conn->error;
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accountSettings'])) {
        $image = $_POST['image'];
        $userName = $_POST['userName'];
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        $userId = $_SESSION['user_id'];
        $validatePasswordQuery = "SELECT password FROM users WHERE id = $userId";
        $validatePasswordResult = $conn->query($validatePasswordQuery);

        if ($validatePasswordResult->num_rows > 0) {
            $row = $validatePasswordResult->fetch_assoc();
            $hashedPassword = $row['password'];

            if (md5($currentPassword) != $hashedPassword) {
                $accountError = 'Current password is incorrect.';
            }
            else if ($newPassword != $confirmPassword){
                $accountError = 'Confirm password is not same as new password.';
            } 
            else if($newPassword == '' or $confirmPassword == '') {
                $accountError = 'Confirm password and new password fields are empty.';
            }
            else {
                
                $hashedNewPassword = md5($newPassword);
                $updatePasswordQuery = "UPDATE users SET password = '$hashedNewPassword' WHERE id = $userId";
                $updatePasswordResult = $conn->query($updatePasswordQuery);

                if ($updatePasswordResult) {
                    $accountSuccess = 'Account settings updated successfully.';
                } else {
                    $accountError = 'Error updating account settings: ' . $conn->error;
                }
            }
        }
    }

 

    $fetchSettingsQuery = "SELECT * FROM settings WHERE id = 1";
    $fetchSettingsResult = $conn->query($fetchSettingsQuery);

    if ($fetchSettingsResult->num_rows > 0) {
        $settings = $fetchSettingsResult->fetch_assoc();
    }

?>

<?php include('includes/header.php');?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <?php include('includes/nav.php');?>
    <?php include('includes/sidebar.php');?>

    <div class="content-wrapper">
        <?php include('includes/pagetitle.php');?>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        
                        <?php
                        if (!empty($systemSuccess)) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $systemSuccess .  '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button></div>';
                        } elseif (!empty($systemError)) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $systemError . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button></div>';
                        }
                        ?>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-cogs"></i> &nbsp; System Settings</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="systemName">System Name</label>
                                        <input type="text" id="systemName" name="systemName" class="form-control"
                                            value="<?php echo isset($settings['system_name']) ? $settings['system_name'] : ''; ?>"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="logo">Logo</label>
                                        <input type="file" id="logo" name="logo" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="currency">Currency</label>
                                        <input type="text" id="currency" name="currency" class="form-control"
                                            value="<?php echo isset($settings['currency']) ? $settings['currency'] : ''; ?>"
                                            required>
                                    </div>

                                    <button type="submit" name="systemSettings" class="btn btn-primary">Update Settings</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            if (!empty($accountSuccess)) {
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $accountSuccess .  '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button></div>';
                            } elseif (!empty($accountError)) {
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $accountError . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button></div>';
                            }
                        ?>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-cogs"></i> &nbsp; Account Settings</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" id="image" name="image" class="form-control">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="userName">Username</label>
                                        <input type="text" id="userName" name="userName" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="currentPassword">Current Password</label>
                                        <input type="password" id="currentPassword" name="currentPassword" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="newPassword">New Password</label>
                                        <input type="password" id="newPassword" name="newPassword" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm Password</label>
                                        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control">
                                    </div>
                                    
                                    <button type="submit" name="accountSettings" class="btn btn-primary">Update Changes</button>
                                </form>

                            </div>

                        </div>
                      
                    </div>
                </div>
            </div>
        </section>
    </div>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
</div>

<?php include('includes/footer.php');?>


</body>

</html>

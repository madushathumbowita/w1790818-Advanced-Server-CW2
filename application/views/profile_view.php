<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/styling/profile.css'); ?>">
</head>
<body>
    <div class="navbar">
            <ul>
                <li><a href="<?php echo site_url('dashboard'); ?>">Home</a></li>
                <li><a href="<?php echo site_url('savedQuestions/index'); ?>">SavedQuestions</a></li>
                <li><a href="<?php echo site_url('tag/list_tags'); ?>">All Tags</a></li>
                <li><a href="<?php echo site_url('profile'); ?>">Profile</a></li>
            </ul>
        </div>
    <h1>User Profile</h1>
    <div class="container">
        <div class="content">
        <div class="welcome">
                <h2 id=welcome >Welcome, <?php echo $user['username']; ?></h2>
            </div>
            <div class="editprofile">
                <h2 id=edit>Edit Profile</h2>
                <form method="post" action="<?php echo site_url('profile/updateUsernameEmail'); ?>">
                    <label for="username">Username:</label>
                    <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
                    <br>
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                    <br>
                    <input type="submit" value="Save">
                </form>
            </div>
            <div class="password">
                <h2>Change Password</h2>
                <form method="post" action="<?php echo site_url('profile/updatePassword'); ?>">
                    <label for="password">New Password:</label>
                    <input type="password" name="password" required>
                    <br>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" required>
                    <br>
                    <input type="submit" value="Save">
                </form>
            </div>
            <form method="post" action="<?php echo site_url('auth/logout'); ?>">
            <input type="submit"  class="logout-btn" value="Logout">
            </form>
        </div>    
    </div>
</body>
</html>
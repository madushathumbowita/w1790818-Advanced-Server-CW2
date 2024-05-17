<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/styling/register.css'); ?>">
</head>
<body>
    <h1>User Registration</h1>
    <?php echo validation_errors(); ?>
    <?php echo form_open('auth/register'); ?>
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo set_value('username'); ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo set_value('email'); ?>" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="http://localhost/advancedservercw/index.php/Auth/login">Login</a></p>
</body>
</html>

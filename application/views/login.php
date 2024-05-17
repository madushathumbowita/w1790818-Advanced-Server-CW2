<!DOCTYPE html>
<html>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Underscore.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <!-- Backbone.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
<head>
    <title>User Login</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/styling/login.css'); ?>">
</head>
<body>
    <h1>User Login</h1>
    <?php echo validation_errors(); ?>
    <form id='loginForm'>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
    <p>Don't have an account ? <a href="<?php echo site_url('auth/register'); ?>">Register</a></p>
    <div id='message'></div>
    <script>
    var UserModel = Backbone.Model.extend({
        defaults: {
            username: '',
            password: ''
        }
    });
    var UserView = Backbone.View.extend({
        el: "#loginForm",
        events: {
            'submit': 'saveUser'
        },
        initialize: function(){
            this.model = new UserModel();
        },
        saveUser: function(event){
            event.preventDefault();

            this.model.set(
                {username: this.$('#username').val(), 
                    password: this.$('#password').val()}
            );
            // Sending data to the server
            $.ajax({
                url: 'http://localhost/advancedservercw/index.php/AuthRequest/login',
                type: 'POST',
                data: this.model.toJSON(),
                xhrFields: {
                    withCredentials: true
                 },
                 success: function(response) {
                    console.log('Request successful');
                    window.location.href = 'http://localhost/advancedservercw/index.php/dashboard/index';
                },           
                error: function(xhr, status, error) {
                    console.error('Error saving data: invalid email or password');
                    var message = 'Invalid Email or Password. Try Again';
                    $('#message').text(message).css({'color': 'red','text-align': 'center','margin-top' : '8px','font-family': 'Calibri',}).show();
                }
            });
        },
    });
    var UserView = new UserView();
    </script>    
</body>
</html>

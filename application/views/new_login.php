<?php
$this->load->view('partial/header');
?>
</head>
<body>
<div class="container">
    <div style="margin-top: 20px" class="row clearfix">
        <div class="col-lg-8" >
            <h1>Greeen Project </br>
                <small>Login</small>
            </h1>
            <img style="margin-top: 50px" src="<?php echo base_url('assests/images/login-background.png'); ?>"
                 class="img-responsive pull-right"/>
        </div>
        <div class="col-lg-4 well" style="margin-top: 150px">
            <center><h1 class="h1">Sign in</h1></center>

            <form id="login" action="<?php echo site_url('user/new_login'); ?>" method="POST">
                <label for="username">Phone Number</label>
                <input class="form-control" type="text" name="username" placeholder="Username"/>
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" placeholder="Password"/>
                <br>
                <input class="btn btn-success" type="submit" value="Login"/>
                <a class="btn btn-info pull-right"
                   href="<?php echo base_url('user/register_collector'); ?>">Register</a>
            </form>

            <form id="login_first" action="<?php echo site_url('user/new_login_first'); ?>" method="POST">
                <label for="username">Phone Number</label>
                <input class="form-control" type="text" name="username" placeholder="Username"/>
                <input class="btn btn-success" type="submit" value="Login"/>
            </form>
            <br/>
            <button class="btn btn-info" id="first">First Visit?</button>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        $('#login_first').hide();
        $('#first').click(function(){
        $('#login').hide();
        $('#first').hide();
        $('#login_first').show();
        });
    });
</script>
</html>

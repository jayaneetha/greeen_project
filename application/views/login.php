
<?php 
$this->load->view('partial/header');
?>
    </head>
    <body>
        <div class="container">
            <div style="margin-top: 120px" class="row clearfix">
                <div class="col-lg-4"></div>
                <div class="col-lg-4 well">
                    <center><h1 class="h1">Sign in</h1></center>
                    <form action="<?php echo site_url('user/login'); ?>" method="POST">
                        <label for="username">Phone Number</label>
                        <input class="form-control" type="text" name="username" placeholder="Username"/>
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Password"/>
                        <input class="btn btn-success" type="submit" value="Login"/>
                        <a class="btn btn-info pull-right" href="<?php echo base_url('user/register_collector'); ?>">Register</a>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

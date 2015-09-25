<?php
$this->load->view('partial/header');
?>
</head>
<body>
<div class="container">
    <div style="margin-top: 20px" class="row clearfix">
        <div class="col-lg-8" >
            <h1>Greeen Project </br>
                <small>Your Details</small>
            </h1>
            <img style="margin-top: 50px" src="<?php echo base_url('assests/images/login-background.png'); ?>"
                 class="img-responsive pull-right"/>
        </div>
        <div class="col-lg-4 well" style="margin-top: 150px">
            <center><h1 class="h1">Your Details</h1></center>
            <form id="login" action="<?php echo site_url('user/update_user'); ?>" method="POST">
                <input type="text" name="user_id" hidden="hidden" value="<?=$user_id?>"/>
                <label for="first_name">First Name</label>
                <input class="form-control" type="text" name="first_name" placeholder="First Name"/>
                <label for="last_name">Last Name</label>
                <input class="form-control" type="text" name="last_name" placeholder="Last Name"/>
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" placeholder="Password"/>
                <label for="password2">Confirm Password</label>
                <input class="form-control" type="password" name="password2" placeholder="Confirm Password"/>
                <br>
                <input class="btn btn-success" type="submit" value="Update"/>

            </form>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    $(document).ready(function(){

    });
</script>
</html>

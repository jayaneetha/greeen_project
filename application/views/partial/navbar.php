<nav class="navbar well-sm well">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <a class="" href="#"><img src="<?php echo base_url('assests/images/Logo.png') ?>" class="img-responsive"
                                          width="150px"/></a>
            </div>
            <div class="col-md-8"><h1 class="text-center">Collectors Dashboard</h1></div>
            <div class="col-md-2">
                <ul class="nav navbar-nav navbar-right" style="vertical-align: middle">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"><?php echo $user->fname; ?>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">My Profile</a></li>
                            <li><a href="<?php echo base_url('index.php/user/logout'); ?>">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
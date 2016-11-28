
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Moderator Page | Add user</title>
    <link rel="shortcut icon" href="../public/webpage_favicon.ico">
   <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="?url=home">Hotel "Posavina"</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="?url=login/index">Login</a>
                    </li>
                    <li>
                        <a href="?url=register/index">Register</a>
                    </li>
                    <li>
                        <a href="?url=rezervacije/index">Rezervacija soba</a>
                    </li>
                    <li>
                        <a href="?url=contact/index">Contact</a>
                    </li>
                     <?php if(Session::exists())
                    {
                        echo "<li><a href='?url=logout'>Log out</a></li>";
                    }
                    ?>
                      <?php
                    if(Session::isAdmin())
                    {
                            echo "<li><a href='?url=adminPage'>ADMIN PANEL</a></li>";
                    }
                    ?>
                    <?php 
                    if(Session::isModerator())
                    {
                            echo "<li><a href='?url=moderatorPage'>MODERATOR PANEL</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-sm-6 text-center">
                <h1>Enter new users data</h1>
                 <form method="POST" action="?url=moderatorPage/addUser" accept-charset="UTF-8" role="form" class="form-signin">
                    <input name="_token" type="hidden" value="Fi3897vD8QKnYc8LQLLOlVpGctWvLB4EnfZZPNbW">
                <fieldset>
                    <input class="form-control" placeholder="Username" name="username" type="text" value="<?php echo $data['username'];?>">
                    <input class="form-control middle" placeholder="E-mail" name="email" type="text" value="<?php echo $data['email'];?>">
                    <input class="form-control middle" placeholder="Password" name="password" type="password" value="">
                    <input class="form-control middle" placeholder="Confirm Password" name="rePassword" type="password" value="">
                    <input class="form-control middle" placeholder="Name" name="name" type="text" value="<?php echo $data['name'];?>">
                    <input class="form-control bottom" placeholder="Last Name" name="lastName" type="text" value="<?php echo $data['lastName'];?>">
                    <input class="form-control bottom" placeholder="City" name="city" type="text" value="<?php echo $data['city'];?>">
                    <input class="form-control bottom" placeholder="Prava" name="prava" type="text" value="">
                    <label for="errorMsg" class="form-control-static"><h3 class="<?php echo $data['errorStyle'];?>"><?php echo $data['errors'];?></h3></label>
                    <input class="btn btn-sm btn-primary btn-block" type="submit" name="addUserButton" value="Add User">
                    
                </fieldset>
            </form>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

</html>

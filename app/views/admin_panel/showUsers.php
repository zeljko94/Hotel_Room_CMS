
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Panel | Show Users</title>

   <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../public/webpage_favicon.ico">
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
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-sms-12 text-center">
                <h1>Admin page</h1>
                <p class="lead">Welcome to admin panel!</p>
                <form action="?url=adminPage/showUsers/<?php echo $data['searchBy'];?>/<?php echo $data['searchKeyword'];?>" method="POST">
                    <input type="text" Placeholder="Search..." name="searchUserKeyword">
                    <select name="searchForm">
                        <option value="">Search by...</option>
                        <option value="username">by username</option>
                        <option value="email">by email</option>
                        <option value="name">by name</option>
                        <option value="lastName">by last name</option>
                        <option value="city">by city</option>
                        <option value="prava">by prava</option>
                        <option value="id">by id</option>
                    </select>
                    <input type="Submit" value="Search" name="searchUsersButton">
                </form>
            </br>
                <table class="table table-bordered">
                    <thead bgcolor="silver">
                        <tr>
                            <td>
                                ID
                            </td>
                            <td>
                                USERNAME
                            </td>
                            <td>
                                PASSWORD
                            </td>
                            <td>
                                EMAIL
                            </td>
                            <td>
                                NAME
                            </td>
                            <td>
                                LAST NAME
                            </td>
                            <td>
                                CITY
                            </td>
                            <td>
                                PRAVA
                            </td>
                        </tr>
                    </thead>
                    <?php foreach($data['users'] as $user){?>
                    <tr>
                        <td>
                            <?php echo $user->getId();?>
                        </td>
                        <td>
                            <?php echo $user->getUsername();?>
                        </td>
                        <td>
                            <?php echo $user->getPassword();?>
                        </td>
                        <td>
                            <?php echo $user->getEmail();?>
                        </td>
                        <td>
                            <?php echo $user->getName();?>
                        </td>
                        <td>
                            <?php echo $user->getLastName();?>
                        </td>
                        <td>
                            <?php echo $user->getCity();?>
                        </td>
                        <td>
                            <?php echo $user->getPrava();?>
                        </td>
                        <td>
                            <a href="?url=adminPage/deleteUser/<?php echo $user->getId();?>">Delete user</a>
                        </td>
                        <td>
                            <a href="?url=adminPage/editUser/<?php echo $user->getId();?>">Edit user</a>
                        </td>
                    </tr>
                    <?php }?>
                    

                </table>
            </div>
        </div>
                </br>
                <a href="?url=adminPage/addUser" class="btn btn-info" role="button">Add new user</a>
        <!-- /.row -->
    </div>
    <!-- /.container -->

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

</html>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="../public/webpage_favicon.ico">
    <title>Naslovna</title>

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
            <div class="col-sm-12 text-center">
                <h1>Naslovna</h1>
                <p class="lead">Dobrodošli na službenu stranicu hotela "Posavina"!</p></br></br>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-sm-12 text-center">
                <div id="myCarousel" class="carousel slide" data-ride="carousel" style="height: 0px;" align="center">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <div class="item active">
                      <img src="http://www.bohinj-park-hotel.si/pic/page/Park-Hotel-Bohinj-soba-double-teak.jpg" width="800" height="300" alt="Soba">
                    </div>

                    <div class="item">
                      <img src="http://freeweb.t-2.net/Damir-Cizmok/images/hotelska%20soba.jpg" width="800" height="300" alt="Apartman">
                    </div>

                    <div class="item">
                      <img src="http://www.urbanresidences.com/_qimages/254_UrbanR%27dam2012014.jpg" height="300" width="800" alt="Penthouse">
                    </div>

                  </div>

                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev" style="color: #000000;">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next" style="color: #000000;">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container -->

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

</html>

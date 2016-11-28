<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="zeljko-10000@hotmail.com">

    <title>Rezervacije</title>
    <link rel="shortcut icon" href="../public/webpage_favicon.ico">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    
    <!-- Load jQuery JS -->
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
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
                <a class="navbar-brand" href="?url=home/index">Hotel "Posavina"</a>
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
                <h1>Rezervacije</h1>
                <h4>NAPOMENA: Nocenje za djecu do 7 godina je besplatno.</h4>
                <table class="table table-bordered" > 
                <!-- prikazi naslov tablice ako ima soba za ispis -->
                <?php /*if(!empty($data['thumbnail'])){*/
                    echo "<thead bgcolor='silver'>
                    <tr>
                        <td>Id</td>
                        <td>Slika sobe</td>
                        <td>Naziv</td>
                        <td>Cijena</td>
                        <td>Max osoba</td>
                        <td>Broj kreveta</td>
                    </tr>
                    </thead>";
               /* } */?>
                <?php foreach($data['thumbnails'] as $thumbnail){ ?>
                    <?php echo "<tr>";?>
                        <?php echo "<td>" . $thumbnail->getId() . "</td>";?>
                        <?php echo "<td style='padding: 0px;margin: 0px;'><a href='index.php?url=rezervacije/prikazSoba/" . $thumbnail->getNaziv() ."' alt=''><img src='" . $thumbnail->getImg_Src() . "' height='250' width='350'></img></a></td>";?>
                        <?php echo "<td>" . $thumbnail->getNaziv() . "</td>";?>
                        <?php echo "<td>" . $thumbnail->getCijena() . " KM</td>";?>
                        <?php echo "<td>" . $thumbnail->getMaxOsoba(). "</td>";?>
                        <?php echo "<td>" . $thumbnail->getBrojKreveta() . "</td>";?>
                        
                    <?php echo "</tr>";?>
                <?php }?>
                </table>

            </br>
            </br>
            </br>
            </br>

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

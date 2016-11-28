
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Moderator Panel | Prikaz Rezervacija</title>

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
            <div class="col-sms-12 text-center">
                <h1>Moderator page</h1>
                <p class="lead">Welcome to moderator panel!</p>
                <form action="?url=adminPage/pregledRezervacija/<?php echo $data['searchBy'];?>/<?php echo $data['searchKeyword'];?>" method="POST">
                    <input type="text" Placeholder="Search..." name="searchRezervacijeKeyword">
                    <select name="searchRezervacijeSelect">
                        <option value="">Search by...</option>
                        <option value="pocetniDatum">by pocetni datum</option>
                        <option value="zavrsniDatum">by zavrsni datum</option>
                        <option value="imeGosta">by ime korisnika</option>
                        <option value="prezimeGosta">by prezime korisnika</option>
                        <option value="emailGosta">by email korisnika</option>
                        <option value="telefonGosta">by telefon korisnika</option>
                        <option value="idSobe">by id sobe</option>
                        <option value="tipSobe">by tip sobe</option>
                    </select>
                    <input type="Submit" value="Search" name="searchRezervacijeButton">
                </form>
            </br>
                <table class="table table-bordered">
                    <thead bgcolor="silver">
                        <tr>
                            <td>
                                ID
                            </td>
                            <td>
                                Pocetni datum
                            </td>
                            <td>
                                Zavrsni datum
                            </td>
                            <td>
                                Ime korisnika
                            </td>
                            <td>
                                Prezime korisnika
                            </td>
                            <td>
                                Email korisnika
                            </td>
                            <td>
                                Telefon korisnika
                            </td>
                            <td>
                                Cijena
                            </td>
                            <td>
                                Datum uplate
                            </td>
                            <td>
                                Id sobe
                            </td>
                            <td>
                                Tip sobe
                            </td>
                        </tr>
                    </thead>         
                    <?php if(!$data['rezervacije']){ echo "<tr><td colspan='11'>Nema rezultata.</td></tr>"; }
                    else
                    {
                        $id=1;
                        foreach($data['rezervacije'] as $rezervacija)
                        {
                            echo "<tr>";
                                echo "<td>" . $id . "</td>";
                                echo "<td>" . $rezervacija->getPocetniDatum() . "</td>";
                                echo "<td>" . $rezervacija->getZavrsniDatum() . "</td>";
                                echo "<td>" . $rezervacija->getImeKorisnika() . "</td>";
                                echo "<td>" . $rezervacija->getPrezimeKorisnika() . "</td>";
                                echo "<td>" . $rezervacija->getEmailKorisnika() . "</td>";
                                echo "<td>" . $rezervacija->getTelefonKorisnika() . "</td>";
                                echo "<td>" . $rezervacija->getCijena() . "</td>";
                                echo "<td>" . $rezervacija->getDatumUplate() . "</td>";
                                echo "<td>" . $rezervacija->getIdSobe() . "</td>";
                                echo "<td>" . $rezervacija->getTipSobe() . "</td>";
                                echo "<td><a href='?url=moderatorPage/brisiRezervaciju/" . $rezervacija->getId() . "'>Brisi rezervaciju</a></td>";
                            echo "</tr>";
                            $id++;
                        } }?>
                </table>
            </div>
        </div>
                </br>
        <!-- /.row -->
    </div>
    <!-- /.container -->

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="zeljko-10000@hotmail.com">

    <title>Rezerviraj sobu</title>
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
   <script type="text/javascript">
    jQuery(function ($)
        {
            $("#pocetniDatum").datepicker({dateFormat: 'dd/mm/yy',
                                            minDate: 0});
            $("#pocetniDatum").datepicker();
        });
    jQuery(function ($){
        $("#zavrsniDatum").datepicker({dateFormat: 'dd/mm/yy',
                                        minDate: 0});
        $("#zavrsniDatum").datepicker();
    });

   </script>

   <script type="text/javascript">
        jQuery(function ($)
        {
            $("#rezervacijaForm").mouseover(function (){
            var poc = $('#pocetniDatum').datepicker('getDate');
            var zavrsni = $('#zavrsniDatum').datepicker('getDate');
            var brojDana = (zavrsni - poc)/1000/60/60/24;
            var brojSoba = <?php echo count($data['odabraneSobe']);?>;
            var cijenaSobe = <?php echo $data['odabraneSobe'][0]->getCijena(); ?>;
            var pansion = $("input[name=pansion]:checked", "#rezervacijeForm").val();
            var pansionCijena = 0;
            switch(pansion)
            {
                case "Pansion":
                pansionCijena = 7.5;
                break;

                case "Polupansion":
                pansionCijena = 5.0;
                break;

                default:
                pansionCijena = 0;
                break;
            }
            var totalCijena = brojSoba * (brojDana * cijenaSobe) + (brojSoba*pansionCijena*brojDana);
            var totalCijenaEl = document.getElementById('totalCijena');
            totalCijenaEl.innerHTML = "TOTAL: " + totalCijena + " KM";
            });
        });
   </script>
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
                    <?php if(Session::exists()) // ako je postavljena sesija znaci da je user ulogiran, zato mu prikazi Logout opciju na meniju
                    {
                        echo "<li><a href='?url=logout'>Log out</a></li>";
                    }
                    ?>
                      <?php
                    if(Session::isAdmin()) // ako je admin prikazi ADMIN PANEL opciju na meniju
                    {
                            echo "<li><a href='?url=adminPage'>ADMIN PANEL</a></li>";
                    }
                    ?>
                    <?php 
                    if(Session::isModerator())  // ako je moderator prikazi MODERATOR PANEL opciju na meniju
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
                <h1>Rezervacije</h1>
                <h3>Smještaj za djecu do 7 godina je besplatan.</h3>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col-sm-6 text-center" id="rezervacijaForm">
                <form method="POST" action="?url=rezervacije/rezervirajSobu/" accept-charset="UTF-8" role="form" id="rezervacijeForm">
                 <input name="_token" type="hidden" value="Fi3897vD8QKnYc8LQLLOlVpGctWvLB4EnfZZPNbW">
                <fieldset>
                   <div class="form-group"> Pocetni datum rezervacije:
                    <label for="pocetniDatum">
                        <input class="form-control" placeholder="Pocetni datum rezervacije" name="pocetniDatum" id="pocetniDatum" type="text" value="<?php echo $data['pocetniDatum'];?>">
                    </label>
                   </div>

                   <div class="form-group"> Datum zavrsetka rezervacije:
                    <label for="zavrsniDatum">
                        <input class="form-control middle" placeholder="Datum zavrsetka rezervacije" name="zavrsniDatum" id="zavrsniDatum" type="text" value="<?php echo $data['zavrsniDatum'];?>">
                   </label>
                   </div>
                    
                    <div class="form-group"> Vaše ime:
                     <label for="imeKorisnika">
                        <input class="form-control middle" placeholder="Ime..." name="imeKorisnika" id="imeKorisnika" type="text" value="<?php echo $data['imeKorisnika'];?>">
                    </label>
                   </div>

                    <div class="form-group"> Vaše prezime:
                     <label for="prezimeKorisnika">
                        <input class="form-control middle" placeholder="Prezime..." name="prezimeKorisnika" id="prezimeKorisnika" type="text" value="<?php echo $data['prezimeKorisnika'];?>">
                    </label>
                   </div>

                    <div class="form-group"> Email:
                     <label for="prezimeKorisnika">
                        <input class="form-control middle" placeholder="Email..." name="emailKorisnika" id="emailKorisnika" type="text" value="<?php echo $data['emailKorisnika'];?>">
                    </label>
                   </div>

                    <div class="form-group"> Broj telefona:
                     <label for="prezimeKorisnika">
                        <input class="form-control middle" placeholder="Broj telefona..." name="telefonKorisnika" id="telefonKorisnika" type="text" value="<?php echo $data['telefonKorisnika'];?>">
                    </label>
                   </div>
                    <input type="radio" value="Pansion" name="pansion">Pansion (+ 7,50 KM)
                    <input type="radio" value="Polupansion" name="pansion">Polupansion (+ 5,00 KM)
                    <input type="radio" value="none" name="pansion">Bez</br>
                    <label for="errorMsg" class="form-control-static"><h3 class="<?php echo $data['errorStyle'];?>"><?php echo $data['errors'];?></h3></label>
                    <h3 class="text-primary" id="totalCijena">TOTAL: <?php echo $data['total'];?> KM</h3>
                    <input class="btn btn-sm btn-primary btn-block" type="submit" name="rezervirajSubmitButton" id="rezervirajSubmitButton" value="Rezerviraj!">
                </fieldset>
            </form>
        </div>
    </div>
    <!-- /.container --> 
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

</html>

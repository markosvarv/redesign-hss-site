<?php include('_session.php'); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/assets/img/favico.ico">

    <title>IKA | Εγγραφή</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link href="/assets/css/justified-nav.css" rel="stylesheet">
    <link href="/assets/css/theme.css" rel="stylesheet">
    <link href="/assets/css/yamm.css" rel="stylesheet">
    <link href="/assets/css/app.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04 -->
    <!-- https://coolors.co/f48e40-0fa3b1-d9e5d6-eddea4-838486 -->
    <!-- https://material.io/icons/#ic_search -->
  </head>

  <body>

    <div class="container">

      <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <?php include('../_menu.php'); ?>
      <?php include('../_flush.php'); ?>

      <div class="registration_cont" id="body">
        <!-- <div class="row">
          <div class="link"> -->
            <a style="float: right; font-size: 18px; margin-top: 5px;" href="/auth/login.php">Έχετε ήδη Λογαριασμό; </a>
         <!--  </div>
        </div> -->
        <h1>Εγγραφή</h1>
        <form action="/auth/authenticate.php?a=register" method="post">
          <div class="row">
            <div class="col-md-4">
              <label for="mail">Διεύθυνση Ηλεκτρονικού Ταχυδρομείου*</label>
            </div>
            <div class="col-md-8">
              <input type="email" id="mail" name="email" placeholder="Εισάγετε email.." required value="<?= $_SESSION['register_email']?>">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="pass">Κωδικός Χρήστη</label>
            </div>
            <div class="col-md-8">
              <input type="password" id="pass" name="password" placeholder="Επιλέξτε Κωδικό..">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="pass">Επανάληψη Κωδικού</label>
            </div>
            <div class="col-md-8">
              <input type="password" id="pass" name="passwordConfirmation" placeholder="Επαναλάβατε τον Κωδικό σας..">
            </div>
          </div>
          <h2>Προσωπικά Στοιχεία</h2>
          <div class="row">
            <div class="col-md-4">
              <label for="name">Όνομα</label>
            </div>
            <div class="col-md-8">
              <input type="text" id="name" name="firstName" placeholder="Εισάγετε το Ονόμα σας.." value="<?= $_SESSION['register_firstName']?>">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="surname">Επίθετο</label>
            </div>
            <div class="col-md-8">
              <input type="text" id="surname" name="lastName" placeholder="Εισάγετε το Επίθετο σας.." value="<?= $_SESSION['register_lastName']?>">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="amka">ΑΜΚΑ</label>
            </div>
            <div class="col-md-8">
              <input type="text" id="amka" name="amka" placeholder="Εισάγετε το ΑΜΚΑ σας.." value="<?= $_SESSION['register_amka']?>" >
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="bdate">Ημερομηνία Γέννησης</label>
            </div>
            <div class="col-md-8">
              <input type="date" id="bdate" name="birthday" placeholder="Εισάγετε την Ημερομηνία Γέννησης σας.." value="<?= $_SESSION['register_birthday']?>">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="address">Διεύθυνση</label>
            </div>
            <div class="col-md-8">
              <input type="text" id="address" name="address" placeholder="Εισάγετε τη Διεύθυνσή σας.." value="<?= $_SESSION['register_address']?>">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="telnumber">Τηλέφωνο</label>
            </div>
            <div class="col-md-8">
              <input type="tel" id="telnumber" name="phone" placeholder="Εισάγετε τον Αριθμό Τηλεφώνου σας.." value="<?= $_SESSION['register_phone']?>">
            </div>
          </div>
          <div class="row" style="margin-top: 10px">
            <div class="col-md-4">
              Αποδέχομαι τους όρους χρήσης  <input type="checkbox" name="terms" value="Bike">
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
              <input type="submit" value="Εγγραφή" class="btn btn-primary btn-lg btn-block">
            </div>
          </div>        
      </div>
      <?php include('../_footer.php'); ?>
      <script type="text/javascript">
        $('#newsTabs a').click(function (e) {
          e.preventDefault();
          $(this).tab('show');
        })
      </script>
  </body>
</html>

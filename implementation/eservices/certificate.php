<?php
include ('../auth/_session.php');
only_loggedin($conn);
?>

<!DOCTYPE html>
<html lang="en">
<html>
<head>

    <!-- Bootstrap core CSS -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/css/bootstrap.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>
    <![endif]-->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>ΙΚΑ | Έκδοση Πιστοποιητικού Online</title>

    <style type="text/css">
        @media print {
            body * {
                visibility: hidden;
            }
            #data_entry, #data_entry * {
                visibility: visible;
            }
            #data_entry {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>

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

</head>
<body>


<div class="container">

    <!-- The justified navigation menu is meant for single line per list item.
         Multiple lines will require custom code not provided by Bootstrap. -->
    <?php include('../_menu.php'); ?>
    <?php include('../_flush.php'); ?>
    <?php 
        $res = $conn->prepare("SELECT * FROM insurance_month INNER JOIN users ON insurance_month.employer=users.id WHERE employee = :id");
        $res->execute(array(':id' => $user["id"]));
        $incusrance_months = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($incusrance_months as $month) {
            $res = $conn->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
            $res->execute(array(':id' => $month['employer']));
        }
    ?>
    <div id="body">

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home.php">Αρχική Σελίδα</a></li>
            <li class="breadcrumb-item active">Έκδοση Πιστοποιητικού Online</li>
        </ol>

        <div class = "page-header">
            <h3>Έκδοση Πιστοποιητικού Online</h3>
        </div>

        <div id="data_entry" style="padding: 10px">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Τύπος Πιστοποιητικού</h4>
                    <form>
                        <select class="form-control status" style="width: 40%" id="selectType">
                            <option disabled selected value style="display:none"> -- Επιλέξτε Τύπο -- </option>
                            <option value="1">Ασφαλιστική Ικανότητα</option>
                            <option value="2">Αναπηρίας </option>
                            <option value="3">κλπ</option>
                        </select>
                        <br>
                        <h4>Στοιχεία Ασφαλισμένου</h4>
                        <p>Το πιστοποιητικό θα εκδοθεί στα παρακάτω στοιχεία:</p>

                        <div class="col-md-6">
                            <div class ="row">
                                <label class="col-md-4">Όνομα:</label>
                                <p class="col-md-8"><?= $user['firstName']?></p>
                            </div>
                            <div class ="row">
                                <label class="col-md-4">Επίθετο:</label>
                                <p class="col-md-8"><?= $user['lastName'] ?></p>
                            </div>
                            <div class ="row">
                                <label class="col-md-4">Email:</label>
                                <p class="col-md-8"><?= $user['email']?></p>
                            </div>
                            <div class ="row">
                                <label class="col-md-4">Ημ/νία Γέννησης:</label>
                                <p class="col-md-8"><?= $user['birthday']?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class ="row">
                                <label class="col-md-4">ΑΜΚΑ:</label>
                                <p class="col-md-8"><?= $user['amka']?></p>
                            </div>
                            <div class ="row">
                                <label class="col-md-4">Περιοχή:</label>
                                <p class="col-lg-8"><?= $user['address'] ?></p>
                            </div>
                            <div class ="row">
                                <label class="col-md-4">Τηλέφωνο:</label>
                                <p class="col-md-8"><?= $user['phone']?></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div style="display: none;" class="panel panel-default" style="" id="results">
              <div class="panel-heading">Αποτελέσματα</div>
              <div class="panel-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ac ipsum lacus. Integer rutrum mauris velit, non accumsan dolor congue ac. Aenean gravida diam neque, at cursus nisl placerat a.</p>
                <table class="table table-striped" id="stoixeia_table">
                    <thead>
                        <tr><th>Μήνας</th><th>Έτος</th><th>Εργοδότης</th><th>Αποδοχές σε ευρώ</th><th></th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($incusrance_months as $month): ?>
                            <tr>
                            <td>
                                <input class="form-control" required disabled value="<?= $month['month'] ?>">
                            </td>
                            <td>
                                <input class="form-control" required disabled value="<?= $month['year'] ?>">
                            </td>
                            <td>
                                <input class="form-control" required disabled value="<?= $month['firstName'] ?> <?= $month['lastName'] ?>">
                            </td>
                            <td>
                                <input class="form-control" type="number" required disabled value="<?= $month['salary'] ?>">
                            </td>
                            <td>    
                            </td>

                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="pull-right">
                    <a href="#" id = "btn3" onclick="print();" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Κατέβασμα ως pdf</a>
                    <button id = "btn2" type="button" class="btn btn-default btn-lg" disabled><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Αποστολή στο email μου</button>
                    <a href="#" id = "btn3" onclick="print();" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Εκτύπωση</a>
                </div>
              </div>
            </div>
        </div>
    </div>
    <?php include('../_footer.php'); ?>
    <script>
        $("#selectType").change(function() {
            if($("#selectType").val()=="1" ){
                $("#results").show();    
            }else{
                $("#results").hide();    
            }
        });

        $(document).on('click', '.yamm .dropdown-menu', function(e) {
            e.stopPropagation()
        });

        $( document ).ready(function() {
            $('select').on('change', function() {
                $('#btn1').attr("disabled", false);
                $('#btn2').attr("disabled", false);
                $('#btn3').attr("disabled", false);
            });
        });
    </script>

</body>
</html>

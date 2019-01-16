<html>
    <head>
        <title>Connexion à la base de données</title>
        <meta charset= "utf-8">
        <link rel="stylesheet" href="bootstrap-4.2.1-dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/style.css"/>
    </head>
    <body>
        <div class="form-group row vt-add-new">
            <div class="col-2 mx-auto">
                <h3 class="text-primary">Information</h3>
            </div>
            <div class="col-6  mx-auto">
                <a href="create.php" class="btn btn-outline-primary">Add new person</a>
            </div>
        </div>
        <?php
            echo "<div class='col-10'>";
                require_once "afficher.php";
            echo "</div>";
        ?>

        <!--liens javascript-->
        <script type="text/javascript" src="js/jquery-v3x.js"></script>
        <script type="text/javascript" src="bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>
    </body>
</html>
<html>
    <head>
        <title>Connexion à la base de données</title>
        <meta charset= "utf-8">
        <link rel="stylesheet" href="bootstrap-4.2.1-dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/style.css"/>
    </head>
    <body class="vt-create-form">
    <form method="post" action="create.php">
            <div class="form-group row">
                <label for="inputName" class="col-sm-2 col-form-label">Firstame</label>
                <div class="col-sm-4">
                <input type="text" name="firstname" class="form-control" id="inputPassword" 
                    placeholder="Your firstname">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputName" class="col-sm-2 col-form-label">Lastname</label>
                <div class="col-sm-4">
                <input type="text" name="lastname" class="form-control" id="inputLastname" 
                    placeholder="Your lastname">
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-4">
                <input type="email" name="email" class="form-control" 
                    id="staticEmail" placeholder="Your e-mail">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPhone" class="col-sm-2 col-form-label">Phone number</label>
                <div class="col-sm-4">
                <input type="text" name="phone" class="form-control" id="inputLastname" 
                    placeholder="Your phone number">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-outline-secondary">Annuler</button>
                </div>
                <div class="col-sm-4">
                    <button type="submit" name="envoyer" class="btn btn-secondary">Envoyer</button>
                </div>
            </div>
        </form>

        <?php
            $user = 'root';
            $pass = '';
            $db = 'connexion';

            $conn = new mysqli('localhost' , $user , $pass , $db);
/**
 * Check connection
*/

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            /**
             * ajouter les données dans le formulaire
             */
            if(isset($_POST['firstname']) && isset($_POST['lastname']) && 
            isset($_POST['email']) && isset($_POST['phone']) ){
                $_firstname = $_POST['firstname'];
                $_lastname = $_POST['lastname'];
                $_email = $_POST['email'];
                $_phone = $_POST['phone'];
            
            /**
             * insérer les données dans la base de données
             */
            $sql = "INSERT INTO information (firstname, lastname, email, phone)
            VALUES ('$_firstname', '$_lastname', '$_email', '$_phone')";
            
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully". "<br/>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close(); 
            }   

        ?>

        <!--liens javascript-->
        <script type="text/javascript" src="js/jquery-v3x.js"></script>
        <script type="text/javascript" src="bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>
    </body>
</html>
<html>
    <head>
        <title>Connexion à la base de données</title>
        <meta charset= "utf-8">
        <link rel="stylesheet" href="bootstrap-4.2.1-dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="fontawesome-free-5.6.3-web/css/all.css"/>
    </head>
    <body>
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

             // Attempt select query execution
             $sql = "SELECT * FROM information";

             if($result = mysqli_query($conn, $sql)){
                 if(mysqli_num_rows($result) > 0){
                     echo "<table class='table col-10 center table-bordered vt-table'>";
                         echo "<thead>";
                             echo "<tr>";
                                 echo "<th>#</th>";
                                 echo "<th>Firstname</th>";
                                 echo "<th>Lastname</th>";
                                 echo "<th>E-mail</th>";
                                 echo "<th>Phone number</th>";
                             echo "</tr>";
                         echo "</thead>";
                         echo "<tbody>";
                         while($row = mysqli_fetch_array($result)){
                             echo "<tr>";
                                 echo "<td>" . $row['id'] . "</td>";
                                 echo "<td>" . $row['firstname'] . "</td>";
                                 echo "<td>" . $row['lastname'] . "</td>";
                                 echo "<td>" . $row['email'] . "</td>";
                                 echo "<td>" . $row['phone'] . "</td>";
                                 echo "<td>";
                                     echo "<a href='read.php?id=". $row['id'] ."' 
                                        title='View ' data-toggle='tooltip'>
                                        <span class='fas fa-eye'></span></a>";
                                     echo "<a href='update.php?id=". $row['id'] ."' 
                                        title='Update ' data-toggle='tooltip'>
                                        <span class='fas fa-edit'></span></a>";
                                     echo "<a href='delete.php?id=". $row['id'] ."' 
                                        title='Delete ' data-toggle='tooltip'>
                                        <span class='fas fa-trash-alt'></span></a>";
                                 echo "</td>";
                             echo "</tr>";
                         }
                         echo "</tbody>";                            
                     echo "</table>";
                     // Free result set
                     mysqli_free_result($result);
                 } else{
                     echo "<p class='lead'><em>No records were found.</em></p>";
                 }
             } else{
                 echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
             }

            $conn->close(); 

        ?>

        <!--liens javascript-->
        <script type="text/javascript" src="js/jquery-v3x.js"></script>
        <script type="text/javascript" src="bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="fontawesome-free-5.6.3-web/js/fontawesome.min.js">
        </script>
        <script type="text/javascript" src="js/script.js"></script>
    </body>
</html>
<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
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
    
    // Prepare a delete statement
    $sql = "DELETE FROM information WHERE id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: index.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="bootstrap-4.2.1-dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="fontawesome-free-5.6.3-web/css/all.css"/>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h3 class="text-secondary">Delete information</h3>
                    </div>
                    <form action="delete.php" method="post">
                        <div class="alert alert-danger" role="alert">
                            <input type="hidden" name="id" value="
                                <?php 
                                    echo trim($_GET["id"]); 
                                ?>"
                            />
                            <p>Are you sure you want to delete this person?</p><br>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>

    <!--liens javascript-->
    <script type="text/javascript" src="js/jquery-v3x.js"></script>
     <script type="text/javascript" src="bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>
</body>
</html>
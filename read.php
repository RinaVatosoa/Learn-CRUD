<?php
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
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
    
    $sql = "SELECT * FROM information WHERE id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        $param_id = trim($_GET["id"]);
        
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set contains 
                 * only one row, we don't need to use while loop 
                */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                $_firstname = $row["firstname"];
                $_lastname = $row["lastname"];
                $_email = $row["email"];
                $_phone = $row["phone"];
            } else{
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
    
    mysqli_close($conn);
} else{
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="bootstrap-4.2.1-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2 class="text-primary">View information</h2>
                    </div>
                    <div class="form-group row">
                        <label class="col-1">Firstname:</label>
                        <div class="text-secondary">
                            <?php echo $row["firstname"]; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1">Lastname :</label>
                        <p class="form-control-static text-secondary"><?php echo $row["lastname"]; ?></p>
                    </div>
                    <div class="form-group row">
                        <label class="col-1">E-mail :</label>
                        <p class="form-control-static text-secondary"><?php echo $row["email"]; ?></p>
                    </div>
                    <div class="form-group row">
                        <label class="col-1">Phone number :</label>
                        <p class="form-control-static text-secondary"><?php echo $row["phone"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
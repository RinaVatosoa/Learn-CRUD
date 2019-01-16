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
     *Define variables and initialize with empty values
    */
    $_firstname = $_lastname = $_email = $_phone = "";
    $_firstname_err = $_lastname_err = $_email_err = $_phone_err = "";
    
    /**
     *Processing form data when form is submitted
    */
    if(isset($_POST["id"]) && !empty($_POST["id"])){
        // Get hidden input value
        $id = $_POST["id"];
        
        /**
         * Validate firstname
         */
        $input_firstname = trim($_POST["firstname"]);
        if(empty($input_firstname)){
            $_firstname_err = "Please enter a firstname.";
        } elseif(!filter_var($input_firstname, FILTER_VALIDATE_REGEXP, array("options"=>array
            ("regexp"=>'/^[a-zA-Z\s]+$/')))){
            $_firstname_err = "Please enter a valid firstname.";
        } else{
            $_firstname = $input_firstname;
        }
        
        /**
         *  Validate address lastname
        */
        $input_lastname = trim($_POST["lastname"]);
        if(empty($input_lastname)){
            $_lastname_err = "Please enter a lastname.";     
        } else{
            $_lastname = $input_lastname;
        }

        /**
         * Validate e-mail
        */
        $input_email = trim($_POST["email"]);
        if(empty($input_email)){
            $_email_err = "Please enter an email.";
        } else{
            $_email = $input_email;
        }
        
        /**
         * Validate phone number
         */
        $input_phone = trim($_POST["phone"]);
        if(empty($input_phone)){
            $_phone_err = "Please enter a valid phone.";     
        } elseif(!ctype_digit($input_phone)){
            $_phone_err = "Please enter a positive phone.";
        } else{
            $_phone = $input_phone;
        }
        
        /**
         * Check input errors before inserting in database
        */
        if(empty($_firstname_err) && empty($_lastname_err) && empty($_email_err) && empty($_phone_err)){
            /**
             *Prepare a update statement
            */
            $sql = "UPDATE information SET firstname=?, lastname=?, email=?, phone=? WHERE id=?";
            
            if($stmt = mysqli_prepare($conn, $sql)){
                /**
                 *Bind variables to the prepared statement as parameters
                */
                mysqli_stmt_bind_param($stmt, "sssss", $param_firstname, $param_lastname, 
                    $param_email, $param_phone, $param_id);
                
                /**
                 *Set parameters
                */
                $param_firstname = $_firstname;
                $param_lastname = $_lastname;
                $param_email = $_email;
                $param_phone = $_phone;
                $param_id = $id;
                
                /** 
                 * Attempt to execute the prepared statement
                */
                if(mysqli_stmt_execute($stmt)){
                    /**
                     * updated successfully. Redirect to landing page
                    */
                    header("location: index.php");
                    exit();
                } else{
                    echo "Something went wrong. Please try again later.";
                }
            }
            
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    } else{
        /**
         * Check existence of id parameter before processing further
         */
        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            /*
             * Get URL parameter
            */
            $id =  trim($_GET["id"]);
            
            $sql = "SELECT * FROM information WHERE id = ?";

            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "i", $param_id);
                $param_id = $id;
                
                /** 
                 * Attempt to execute the prepared statement
                */
                if(mysqli_stmt_execute($stmt)){
                    $result = mysqli_stmt_get_result($stmt);
        
                    if(mysqli_num_rows($result) == 1){
                        /* 
                        * Fetch result row as an associative array. Since the result set 
                        *contains only one row, we don't need to use while loop 
                        */
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        
                        /**
                        * Retrieve individual field value
                        */
                        $_firstname = $row["firstname"];
                        $_lastname = $row["lastname"];
                        $_email = $row["email"];
                        $_phone = $row["phone"];
                    } else
                    {
                        header("location: error.php");
                        exit();
                    }
                    
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            mysqli_stmt_close($stmt);
            
            mysqli_close($conn);
        }  else{
            header("location: error.php");
            exit();
        }
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update information</title>
    <link rel="stylesheet" href="bootstrap-4.2.1-dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="fontawesome-free-5.6.3-web/css/all.css"/>
    <style rel="stylesheet" type="text/css" href="css/style.css"></style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update information</h2>
                    </div>
                    <p>Please edit the input values and submit to update the information.</p>
                    <form action="update.php" method="post">
                        <div class="form-group 
                            <?php 
                                echo (!empty($_FILES)) ? 'has-error' : ''; 
                            ?>">
                            <label>Firstname</label>
                            <input type="text" name="firstname" class="form-control" value="
                            <?php 
                                echo $_firstname; 
                            ?>">
                            <span class="help-block"><?php echo $_firstname_err;?></span>
                        </div>
                        <div class="form-group 
                            <?php 
                                echo (!empty($_FILES)) ? 'has-error' : ''; 
                            ?>">
                            <label>Lastname</label>
                            <input type="text" name="lastname" class="form-control" value="
                            <?php 
                                echo $_lastname; 
                            ?>">
                            <span class="help-block"><?php echo $_lastname_err;?></span>
                        </div>
                        <div class="form-group 
                            <?php 
                                echo (!empty($_FILES)) ? 'has-error' : ''; 
                            ?>">
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control" value="
                            <?php 
                                echo $_email; 
                            ?>">
                            <span class="help-block"><?php echo $_email_err;?></span>
                        </div>
                        <div class="form-group 
                            <?php 
                                echo (!empty($_FILES)) ? 'has-error' : ''; 
                            ?>">
                            <label>Phone number</label>
                            <input type="text" name="phone" class="form-control" value="
                            <?php 
                                echo $_phone; 
                            ?>">
                            <span class="help-block"><?php echo $_phone_err;?></span>
                        </div>
                        
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
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
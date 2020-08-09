<?php
include("includes/header.inc.php");

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
    header("location:index.php");
    exit;
}
require_once('config.php');

$username = $password = "";
$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] = "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username";
    }
    else{
        $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter password";
    }
    else{
        $password = trim($_POST["password"]);
    }

    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = $con->prepare($sql)){
            $stmt->bind_param("s", $param_username);
            $param_username = $username;

            if($stmt->execute()){
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            header("location: index.php");
                        }
                        else{
                            $password_err = "Invalid password";
                        }
                    }
                }
                else{
                    $username_err = "invalid username";
                }
            }
            else{
                echo "Something went wrong!!!";
            }
            $stmt->close();
        }
    }
    $con->close();
}

?>

<div class="container" style="width: 400px;">
    <h2>Login</h2>
    <small>Please fill in your credentials</small>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>    
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Do not have an account? <a href="register.php">Register here</a>.</p>
    </form>
</div>


<?php
include("includes/footer.inc.php");
?>
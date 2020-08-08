<?php
    include("includes/header.inc.php");
    include("config.php");
    include("includes/flashmsg.inc.php");
    $flashmsg = new flashmsg();

    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(empty(trim($_POST["username"]))){
            $username_err = "please enter a username";
        }
        else{
            $sql = "SELECT id FROM users WHERE username = ?";
            if($query = $con->prepare($sql)){
                $query->bind_param("s", $param_username);
                $param_username = trim($_POST["username"]);

                if($query->execute()){
                    $query->store_result();

                    if($query->num_rows == 1){
                        $username_err = "this username is already taken";
                    }
                    else{
                        $username = trim($_POST["username"]);
                    }
                }
                else{
                    echo "Something went wrong!!!";
                }
                $query->close();
            }
        }
        if(empty(trim($_POST["password"]))){
            $password_err = "please enter a password";
        }
        else{
            $password = trim($_POST["password"]);
        }
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm password.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }

        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
            $sql = "INSERT INTO users (username, password) VALUES(?,?)";
            if($stmt = $con->prepare($sql)){
                $stmt->bind_param("ss", $param_username, $param_password);
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT);
                if($stmt->execute()){
                    // Redirect to login page
                    header("location: index.php");
                } else{
                    echo "Something went wrong. Please try again later.";
                }
    
                // Close statement
                $stmt->close();
            }
        }
    }
?>
<br>
<div class="container" style="width: 400px;">
    <h2>Sign Up</h2>
    <small>Please sign up here</small>

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
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>
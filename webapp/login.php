<?php
// Initialize the session
session_start();

//Crear Cookies

    if($_POST) {
        if(isset($_POST["recordarme"]) && $_POST["recordarme"] == 1){

            setcookie("usuario", $_POST['email'], time()+3600);

            }
    }


// Check if the user is already logged in, if yes then redirect him to welcome page

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
        {
         header("location: IngresosGastos.php");
         exit;
        }

    // Include config file
    require_once "config/configuracion.php";

    // Define variables and initialize with empty values


     $email = $password = "";
     $email_err = $password_err = $login_err = "";

    // Processing form data when form is submitted
     if ( $_SERVER["REQUEST_METHOD"] == "POST" )
        {


            // Check if username is empty
            if(empty(trim($_POST["email"]))){
                $email_err = "Please enter username.";
            } else{
                $email = trim($_POST["email"]);
            }

            // Check if password is empty
            if(empty(trim($_POST["password"]))){
                $password_err = "Please enter your password.";
            } else{
                $password = trim($_POST["password"]);
            }

            // Validate credentials
             if ( empty($email_err) && empty($password_err) )
                {
                         // Prepare a select statement
                         $sql = "SELECT id, email, password FROM usuarios WHERE email = ?";
                     if ( $stmt = $mysqli->prepare($sql) )
                        {
                             // Bind variables to the prepared statement as parameters
                             $stmt->bind_param("s", $param_email);
                             // Set parameters
                             $param_email = $email;
                         // Attempt to execute the prepared statement
                         if ( $stmt->execute() )
                            {
                                // Store result
                              $result = $stmt->get_result();

                             // Check if username exists, if yes then verify password
                              if ($result->num_rows == 1)
                                 {
                                    //echo 'He encontrado al usuario';
                                    // Bind result variables

                                  if ( $DatosUsuario = $result->fetch_assoc() )
                                     {
                                       if ( password_verify($password, $DatosUsuario["password"]) )
                                          {
                                           // Password is correct, so start a new session
                                          if (!isset($_SESSION))
                                             {
                                              session_start();
                                             }

                                            // Store data in session variables
                                            $_SESSION["loggedin"] = true;
                                            $_SESSION["id"] = $DatosUsuario["id"];
                                            $_SESSION["email"] = $DatosUsuario["email"];


                                            // Redirect user to welcome page
                                                    header("location: IngresosGastos.php");
                                         }
                                      else
                                         {
                                            // Password is not valid, display a generic error message
                                            $login_err = "Usuario o password incorrectos.";
                                         }
                                    }
                                  }
                               else
                                  {
                                   // Username doesn't exist, display a generic error message
                                   $login_err = "Usuario o Password incorrectos.";
                                  }
                             }
                         else
                            {
                             echo "Oops! Something went wrong. Please try again later.";
                            }
                             // Close statement
                             $stmt->close();
                        }
                }
                // Close connection
                $mysqli->close();
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ("Cabecera.php") ?>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">CuentasApp</a>
        </div>
    </div>
</nav>


<div class="container-fluid ">
    <h2>Login</h2>
    <p>Por favor, introduce tus credenciales para entrar:</p>

    <?php
    if(!empty($login_err)){
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]); ?>" method="post">
        <div class="form-group">
            <label>Email</label>
            <label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
            </label>
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <label>Password</label>
            <label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
            </label>
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>¿No tienes una cuenta?<a href="registro.php"> Registrate ahora</a>.</p>
    </form>
</div>


</body>
</html>
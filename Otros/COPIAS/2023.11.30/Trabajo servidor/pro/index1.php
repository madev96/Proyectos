
                <?php
                    
                    session_start(); //se inicia la sesión.
                    $email = $_POST['email'];
                    $_SESSION["email"] = $email;

                    //Redirigir 
                    header("Location: principal.php")
                ?>
                
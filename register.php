<?php
    include('./Controllers/DatabaseController.php');
    include('./Controllers/UserController.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errorMessage = null;

        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_conf'])
            && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_conf'])) 
        {
            
            $db = connectDb();

            $email = $_POST['email'];
            $pass = $_POST['password'];
            $pass_conf = $_POST['password_conf'];

            $status = tryRegister($db, $email, $pass, $pass_conf)['status'];

            closeDb($db);

            if ($status == 0) {
                // success
                $errorMessage = null;

                setcookie("email", $email);
                setcookie("pass", $pass);

                // Redirect into login
                header("Location: /dashboard-table.php");
            } 
            else if ($status == 1) {
                // email not found
                $errorMessage = "Email exist! Please login!";
            }
            else if ($status == 2) {
                // wrong password
                $errorMessage = "Password confirmation don't match!";
            } else {
                $errorMessage = "Unknown error, please try again!";
            }
        } else {
            $errorMessage = "Please enter valid email and password!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="./style.css" />
    <title>Register</title>
</head>
<body class="container-sm content-center min-height">
    <form class="card" action="./register.php" method="POST">
        <h1 class="text-center mb-3">Register</h1>
        <p class="text-center mb-3">Regis dulu bg.</p>
        <?php if (isset($errorMessage) && $errorMessage != null) { ?>
            <div class="alert alert-danger">
                <?php echo $errorMessage; ?>
            </div>
        <?php } ?>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" />
            <div class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" />
            <div class="form-text">Input your password.</div>
        </div>
        <div class="mb-3">
            <label for="password_conf" class="form-label">Password Confirmation</label>
            <input type="password" name="password_conf" class="form-control" />
            <div class="form-text">Input your password once more.</div>
        </div>
        <div class="mb-3">
            <span class="form-text">Already have an account? <a href="/">Login</a> here.</span>
        </div>
        <input type="submit" class="form-control" />
    </form>
</body>
</html>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errorMessage = null;

        function connectDb() {
            $host = 'localhost';
            $uname = 'root';
            $pass = '';
            $db = 'pweb_bank';
            $mysqli = mysqli_connect($host, $uname, $pass, $db);

            if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
                exit();
            }

            return $mysqli;
        }

        function closeDb($db) {
            mysqli_close($db);
        }

        function checkLogin($db, $email, $password) {
            if ($res = $db->query("select * from users where email = \"$email\";")) {
                if ($res->num_rows == 1) {
                    // exist
                    $row = $res->fetch_row();
                    if ($row[2] == $password) {
                        // password same
                        return 0;
                    } else {
                        return 2;
                    }
                }

                $res->free_result();
                
                return 1;
            }

            return -1;
        }

        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $db = connectDb();

            $email = $_POST['email'];
            $pass = $_POST['password'];

            $status = checkLogin($db, $email, $pass);

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
                $errorMessage = "Email not found! Please register!";
            }
            else if ($status == 2) {
                // wrong password
                $errorMessage = "Wrong password, please try again!";
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
    <title>Login</title>
</head>
<body class="container-sm content-center min-height">
    <form class="card" action="." method="POST">
        <h1 class="text-center mb-3">Login</h1>
        <p class="text-center mb-3">Login dulu bg.</p>
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
        <input type="submit" class="form-control" />
    </form>
</body>
</html>
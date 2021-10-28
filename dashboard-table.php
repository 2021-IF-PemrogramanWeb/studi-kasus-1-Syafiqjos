<?php
    include('./DatabaseController.php');
    include('./UserController.php');
    include('./BankController.php');

    if (isset($_COOKIE['email']) && isset($_COOKIE['pass'])){
        $db = connectDb();

        $email = $_COOKIE['email'];
        $pass = $_COOKIE['pass'];

        $login = checkLogin($db, $email, $pass);
        $status = $login['status'];
        $user = $login['data'];

        $bankData = null;

        if ($status == 0) {
            // if login successfully
            $bankData = getBankData($db, $user['id']);
        } else {
            header("Location: /");
            exit();
        }

        closeDb($db);
    } else {
        header("Location: /");
        exit();
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
    <title>Dashboard - Table</title>
</head>
<body class="min-height">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Bank PWEB</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="/dashboard-table.php">Table</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard-graph.php">Graph</a>
                    </li>
                </ul>
                <form class="d-flex" method="POST" action="./logout.php">
                    <span class="m-2"><?php echo($email); ?></span>
                    <button class="btn btn-outline-danger" type="submit">Logout</button>
                </form>
            </div>
        </nav>
    </header>
    <main class="container-lg p-3">
        <h1 class="display-2">Bank History</h1>
        <div>
            <p>Here goes your bank history.</p>
        </div>
        <div>
            <h3 class="display-6 mt-2">Add New Data</h3>
            <form class="container-fluid" action="./addBankdata.php" method="POST">
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="description" name="description" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="value" class="form-label">Value</label>
                    <input type="number" name="value" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" />
                </div>
                <input type="submit" class="form-control" />
            </form>
        </div>
        <div>
            <h3 class="display-6 mt-2">Table Preview</h3>
            <?php if (count($bankData) > 0) { ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Description</th>
                            <th>Value</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($bankData as $row) { $i++; ?>
                            <tr>
                                <td><?php echo($i); ?>.</td>
                                <td><?php echo($row['description']); ?></td>
                                <td><?php echo($row['value']); ?></td>
                                <td><?php echo(date_format(date_create($row['date']), "d/m/Y")); ?></td>
                                <td>
                                    <form action="./deleteBankData.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo($row['id']); ?>" />
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="mt-4 mb-4 h6 text-center">No Data</div>
            <?php } ?>
        </div>
    </main>
</body>
</html>
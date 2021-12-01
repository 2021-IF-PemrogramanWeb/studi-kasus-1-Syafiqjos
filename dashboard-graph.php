<?php
    include('./Controllers/DatabaseController.php');
    include('./Controllers/UserController.php');
    include('./Controllers/BankController.php');
    include('./Controllers/helper.php');

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard - Graph</title>
</head>
<body class="min-height">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Bank PWEB</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard-table.php">Table</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/dashboard-graph.php">Graph</a>
                    </li>
                </ul>
                <form class="d-flex" method="POST" action="./actions/logout.php">
                    <span class="m-2"><?php echo(normalize_html($email)); ?></span>
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
            <form class="container-fluid" action="./actions/addBankData.php" method="POST">
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
            <h3 class="display-6 mt-2">Graph Preview</h3>
            <canvas id="graph-preview"></canvas>
        </div>
    </main>
    <script>
        const labels = [
            'Begin',
            <?php 
                if ($bankData != null) {
                    $c = count($bankData); 
                    for ($i = 0; $i < $c; $i++) {
                        $row = $bankData[$i];
                        $truncatedDate = date_format(date_create($row['date']), "d/m/Y");
                        echo("'$truncatedDate',");
                    }
                } 
            ?>
        ];

        const data = {
            labels: labels,
            datasets: [{
                label: 'Deposit',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [
                    0, 
                    <?php 
                        if ($bankData != null) {
                            $c = count($bankData);
                            $acc = 0;
                            for ($i = 0; $i < $c; $i++) {
                                $val = $bankData[$i]['value'];
                                $acc += $val;
                                echo("$acc,");
                            }
                        }
                    ?>
                ],
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };
        const graphPreview = new Chart(document.getElementById('graph-preview'), config);
    </script>
</body>
</html>
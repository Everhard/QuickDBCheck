<?php
if (isset($_POST['form'])) {

    $form_data = $_POST['form'];

    $response = [
            'error' => false,
    ];

    $quickdbcheck = new QuickDBCheck(
            $form_data['host-name'],
            $form_data['database-username'],
            $form_data['database-password']
    );

    $response['auth_passed'] = $quickdbcheck->isAuthPassed() ? 1 : 0;

    echo json_encode($response);

    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>QuickDBCheck</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        body {
            background: #343a40;
        }
        #main {
            width: 40%;
            border-radius: 21px;
            padding: 50px 0;
        }
        #main .card-body {
            min-height: 275px;
            color: #212529;
        }
        #main .card-body ul {
            margin-bottom: 15px;
        }
        @media all and (max-width: 700px) {
            #main {
                width: 90%;
            }
        }
        #form {
            width: 90%;
            margin: 0 auto;
            color: #212529;
        }
    </style>
</head>
<body>

<div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white">
    <div class="my-3 py-3">
        <h2 class="display-5">QuickDBCheck</h2>
        <p class="lead">Written by <a href="http://dorohoff.net">Andrew Dorokhov</a></p>
    </div>
    <div id="main" class="bg-light shadow-sm mx-auto text-left row">
        <div class="col-sm">
            <form id="form" method="post">
                <div class="form-group">
                    <label for="host-name">Host name:</label>
                    <input type="text" name="form[host-name]" class="form-control" id="host-name" placeholder="Enter host name" value="localhost">
                    <small class="form-text text-muted">For example, localhost</small>
                </div>
                <div class="form-group">
                    <label for="database-username">Database username:</label>
                    <input type="text" name="form[database-username]" class="form-control" id="database-username" placeholder="Enter database username">
                </div>
                <div class="form-group">
                    <label for="host-name">Database password:</label>
                    <input type="password" name="form[database-password]" class="form-control" id="database-password" placeholder="Enter database password">
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-lg btn-success">Check credentials</button>
                </div>
            </form>
        </div>
        <div class="col-sm">
            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#result" href="#">Result</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#databases" href="#">Databases</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body tab-content">
                    <div id="result" class="tab-pane fade show active">
                        <ul class="list-group text-left">
                            <li class="list-group-item">Auth: <strong class="text-success">Success</strong></li>
                            <li class="list-group-item">Error: SQLSTATE[HY000] [1045] Access denied for user 'andrew'@'localhost' (using password: YES)</li>
                            <li class="list-group-item">Error code: 1045</li>
                        </ul>
                        <a href="#" class="btn btn-primary">Show databases</a>
                    </div>
                    <div id="databases" class="tab-pane fade">
                        <h3>Databases list</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
    $(function() {
        $("#form").on('submit', function(e) {
            $.ajax({
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                }
            });
            e.preventDefault();
        });
    });
</script>
</body>
</html>

<?php

class QuickDBCheck
{
    private $dbh;
    private $error;

    public function __construct($host_name, $db_username, $db_password)
    {
        try {
            $this->dbh = new PDO("mysql:host=$host_name", $db_username, $db_password);
        }
        catch(PDOException $e) {
            $this->error = [
                'code'      => $e->getCode(),
                'message'   => $e->getMessage(),
            ];
        }
    }

    public function isAuthPassed()
    {
        return $this->error ? false : true;
    }
}
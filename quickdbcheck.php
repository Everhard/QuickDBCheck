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
    <div id="main" class="bg-light shadow-sm mx-auto text-left">
        <form id="form" method="post">
            <div class="form-group">
                <label for="host-name">Host name:</label>
                <input type="text" class="form-control" id="host-name" placeholder="Enter host name" value="localhost">
                <small class="form-text text-muted">For example, localhost</small>
            </div>
            <div class="form-group">
                <label for="database-username">Database username:</label>
                <input type="text" class="form-control" id="database-username" placeholder="Enter database username">
            </div>
            <div class="form-group">
                <label for="host-name">Database password:</label>
                <input type="password" class="form-control" id="database-password" placeholder="Enter database password">
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-lg btn-success">Check credentials</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
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
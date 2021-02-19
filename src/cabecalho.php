<?php
include '../conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8" />
        <title>SIS CarSelect</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="../css/bootstrap.min.css" rel="stylesheet"
              id="bootstrap-css">


        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css" />

        <script type="text/javascript" href="../js/script.js"></script>


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    </head>
    <body>
        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-dark bg-danger mt-5">

                <a class="navbar-brand" href="#"> <img src="img/logo1.jpg"
                                                       class="img-fluid" alt="Logo" height="90" width="90">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSite">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSite">

                    <ul class="navbar-nav mr-auto ml-auto">
                        <li class="nav-item"><a class="nav-link" href="frm_cad_cliente.php">Cadastro
                                de Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="frm_cad_empresa.php">Cadastro da Empresa</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Lancamento OS</a></li>
                    </ul>
                </div>
            </nav>
            <div class="row card-content">
                <div class="input-field col s12" align="right">
                    <form  action="lista_cliente.php" method="get">
                        <input type="text" data-length="10" id="termo" name="termo"
                               placeholder="Infome o Nome ou CPF do Cliente">
                        <button class="btn btn-primary btn-lg btn-block btn-danger" type="submit">Localizar Clientes</button>
                    </form>
                </div>

            </div>
        </div>

    </body>
</html>
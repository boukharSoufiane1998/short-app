<?php
session_start();
if (isset($_SESSION['email'])) {
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
} else {
    header('location:index.php');
}

if (isset($_POST["logOUT"])) {
    session_destroy();
    header('location:index.php');
}
require_once('config.php');
require_once('php/stagiaire.php');
if (isset($_POST["deleteAccount"])) {
    $dbDeleteAccount = new GestionStagiaire($pdo);
    $deleteAccount = $dbDeleteAccount->deleteStagiare($email, $prenom, $nom);
    if ($deleteAccount === TRUE) {
        session_destroy();
        header('location:index.php');
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/" class="d-flex align-items-center p-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">StagiairePlus</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 p-2 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Skills</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Contact</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1"><?php echo $nom . ' ' . $prenom; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="stagiaire.php">Profil</a></li>
                            <li>
                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal">Supprimer mon compte</button>
                            </li>
                            <form action="" method="post">
                                <button type="submit" name="logOUT" class="dropdown-item">Deconnexion</button>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3">
                <h3 class="lead" style="margin-bottom: 50px;margin-top:20px;">La liste des stagiaires</h3>

                <div class="container">
                    <table id="data-table" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Email</th>
                                <th>Ville</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            require_once('config.php');
                            require_once('php/gestionStagiaire.php');

                            $stagiaireFunctions = new GestionStagiaire($pdo);
                            $stagiaires = $stagiaireFunctions->showStagiaire();

                            if (!empty($stagiaires)) {
                                foreach ($stagiaires as $data) {
                                    $stagiaire = $data['stagiaire'];
                                    $ville = $data['ville'];
                                    
                                    echo '<tr>';
                                    echo '<td>' . $stagiaire->getNom() . '</td>';
                                    echo '<td>' . $stagiaire->getPrenom() . '</td>';
                                    echo '<td>' . $stagiaire->getEmail() . '</td>';
                                    echo '<td>' . $ville . '</td>';
                                    echo '</tr>';
                                }
                            }

                            ?>
                        </tbody>
                    </table>

                </div>



            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Supression de compte</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="lead">Voulez-vous supprimer votre compte ?</h3>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quitter</button>
                    <form action="" method="post">
                        <button type="submit" name="deleteAccount" class="btn btn-primary">Oui</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#data-table').DataTable({
                paging: true,
                pageLength: 10
            });
            $('#data-table').addClass('custom-datatable');
            $('#data-table thead').css('background-color', '#0e67b2');
            $('#data-table th, #data-table td').css({
                'padding': '10px',
                'text-align': 'center'
            });
            $('#data-table tbody td').css('background-color', '#c0c0c0');
            $('#data-table tbody tr:nth-child(even)').css('background-color', '#f9f9f9');
            $('#data-table_filter input').css('margin-bottom', '20px');
        });
    </script>

</body>

</html>
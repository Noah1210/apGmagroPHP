<?php

session_start();
ini_set('display_errors', 'on');
error_reporting(E_ALL);
include_once 'PdoBD.php';
$pdo = PdoBD::getPdoBD();
$uc = filter_input(INPUT_GET, "uc", FILTER_SANITIZE_STRING);
if ($uc && $uc != '') {
    header('Content-Type: application/json');
    if (!isset($_SESSION['login'])) {
        switch ($uc) {
            case 'getConnexion' :
                $loginInterv = filter_input(INPUT_GET, "loginInterv", FILTER_SANITIZE_STRING);
                $md5Password = filter_input(INPUT_GET, "md5Password", FILTER_SANITIZE_STRING);
                $intervenant = $pdo->getConnexion($loginInterv, $md5Password);
                if ($intervenant) {
                    $_SESSION['login'] = $loginInterv;
                    echo json_encode($intervenant, JSON_PRETTY_PRINT);
                } else {
                    echo 0;
                }
                break;
            case "test" :
                echo "bouhhhh";
                break;
        }
    } else {
        switch ($uc) {
            case 'deconnexion' :
                session_destroy();
                break;
            case 'getIntervenant' :
                $intervenant = $pdo->getIntervenant();
                if ($intervenant) {
                    echo json_encode($intervenant, JSON_PRETTY_PRINT);
                } else {
                    echo 0;
                }
                break;
            case 'addIntervenant' :
                $loginInterv = filter_input(INPUT_GET, "loginInterv", FILTER_SANITIZE_STRING);
                $md5Password = filter_input(INPUT_GET, "md5Password", FILTER_SANITIZE_STRING);
                $nomInterv = filter_input(INPUT_GET, "nomInterv", FILTER_SANITIZE_STRING);
                $prenomInterv = filter_input(INPUT_GET, "prenomInterv", FILTER_SANITIZE_STRING);
                $mail = filter_input(INPUT_GET, "mail", FILTER_SANITIZE_EMAIL);
                $actif = filter_input(INPUT_GET, "actif", FILTER_UNSAFE_RAW);
                if ($actif == "true") {
                    $actif = "1";
                }
                $codeRole = filter_input(INPUT_GET, "codeRole", FILTER_SANITIZE_STRING);
                $codeSite = filter_input(INPUT_GET, "codeSite", FILTER_SANITIZE_STRING);
                $intervenant = $pdo->addIntervenant($loginInterv, $md5Password, $nomInterv, $prenomInterv, $mail, $actif, $codeRole, $codeSite);
                if ($intervenant) {
                    echo json_encode($intervenant, JSON_PRETTY_PRINT);
                } else {
                    echo 0;
                }
                break;
            case 'delIntervenant' :
                $loginInterv = filter_input(INPUT_GET, "loginInterv", FILTER_SANITIZE_STRING);
                $delIntervenant = $pdo->delIntervenant($loginInterv);
                if ($delIntervenant) {
                    echo json_encode($delIntervenant, JSON_PRETTY_PRINT);
                } else {
                    echo 0;
                }
                break;
            case 'updateIntervenant':
                $loginInterv = filter_input(INPUT_GET, "loginInterv", FILTER_SANITIZE_STRING);
                $md5Password = filter_input(INPUT_GET, "md5Password", FILTER_SANITIZE_STRING);
                $nomInterv = filter_input(INPUT_GET, "nomInterv", FILTER_SANITIZE_STRING);
                $prenomInterv = filter_input(INPUT_GET, "prenomInterv", FILTER_SANITIZE_STRING);
                $mail = filter_input(INPUT_GET, "mail", FILTER_SANITIZE_EMAIL);
                $actif = filter_input(INPUT_GET, "actif", FILTER_UNSAFE_RAW);
                $oldLogin = filter_input(INPUT_GET, "oldLogin", FILTER_SANITIZE_STRING);
                if ($actif == "true") {
                    $actif = "1";
                }
                $codeRole = filter_input(INPUT_GET, "codeRole", FILTER_SANITIZE_STRING);
                $codeSite = filter_input(INPUT_GET, "codeSite", FILTER_SANITIZE_STRING);
                $intervenant = $pdo->updateIntervenant($loginInterv, $md5Password, $nomInterv, $prenomInterv, $mail, $actif, $codeRole, $codeSite, $oldLogin);
                if ($intervenant) {
                    echo json_encode($intervenant, JSON_PRETTY_PRINT);
                } else {
                    echo 0;
                }
                break;
            case 'getRole' :
                $role = $pdo->getRole();
                if ($role) {
                    echo json_encode($role, JSON_PRETTY_PRINT);
                } else {
                    echo 0;
                }
                break;
            case 'getSite' :
                $site = $pdo->getSite();
                if ($site) {
                    echo json_encode($site, JSON_PRETTY_PRINT);
                } else {
                    echo 0;
                }
                break;
        }
    }
} else {
    echo "il manque uc";
}


    
<?php

class PdoBD {

    private static $serveur = 'mysql:host=192.168.153.10';
    private static $bdd = 'dbname=202223_gmagro_npardon';
    private static $user = 'npardon';
    private static $mdp = 'cabanon';
    private $pdo = null;
    private static $pdoBd = null;

    private function __construct() {
        $this->pdo = new PDO(PdoBD::$serveur . ';' . PdoBD::$bdd, PdoBD::$user, PdoBD::$mdp);
        $this->pdo->query("SET CHARACTER SET utf8");
    }

    public function _destruct() {
        PdoBD::$pdo = null;
    }

    public static function getPdoBD() {
        if (PdoBD::$pdoBd == null) {
            PdoBD::$pdoBd = new PdoBD();
        }
        return PdoBD::$pdoBd;
    }

    public function getConnexion($loginInterv, $md5Password) {
        $req = "select * from Intervenant where loginInterv = :login and md5Password = md5(:mdp) ";
        $st = $this->pdo->prepare($req);
        $st->bindValue(":login", $loginInterv);
        $st->bindValue(":mdp", $md5Password);
        $st->execute();
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function getIntervenant() {
        $req = "select * from Intervenant";
        $st = $this->pdo->prepare($req);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRole() {
        $req = "select codeRole from Role";
        $st = $this->pdo->prepare($req);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSite() {
        $req = "select * from Site";
        $st = $this->pdo->prepare($req);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addIntervenant($loginInterv, $md5Password, $nomInterv, $prenomInterv, $mail, $actif, $codeRole, $codeSite) {
        $req = "insert into Intervenant(loginInterv, md5Password, nomInterv, prenomInterv, mail, actif, codeRole, codeSite) values (:login , md5(:mdp) , :nom , :prenom , :mail , :actif , :role , :site)";
        $st = $this->pdo->prepare($req);
        $st->bindValue(":login", $loginInterv);
        $st->bindValue(":mdp", $md5Password);
        $st->bindValue(":nom", $nomInterv);
        $st->bindValue(":prenom", $prenomInterv);
        $st->bindValue(":mail", $mail);
        $st->bindValue(":actif", $actif);
        $st->bindValue(":role", $codeRole);
        $st->bindValue(":site", $codeSite);
        $res = $st->execute();
        if ($res) {
            return res;
        }
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateIntervenant($loginInterv, $md5Password, $nomInterv, $prenomInterv, $mail, $actif, $codeRole, $codeSite, $oldLogin) {
        $req = "UPDATE Intervenant set loginInterv = :login ,  md5Password = :mdp , nomInterv = :nom , prenomInterv = :prenom , mail = :mail , actif = :actif , codeRole = :role , codeSite = :site WHERE loginInterv = :oldLogin ";
        $st = $this->pdo->prepare($req);
        $st->bindValue(":login", $loginInterv);
        $st->bindValue(":mdp", $md5Password);
        $st->bindValue(":nom", $nomInterv);
        $st->bindValue(":prenom", $prenomInterv);
        $st->bindValue(":mail", $mail);
        $st->bindValue(":actif", $actif);
        $st->bindValue(":role", $codeRole);
        $st->bindValue(":site", $codeSite);
        $st->bindValue(":oldLogin", $oldLogin);
        $res = $st->execute();
        if ($res) {
            return res;
        }
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delIntervenant($loginInterv) {
        $req = "DELETE FROM Intervenant WHERE  loginInterv = :login";
        $st = $this->pdo->prepare($req);
        $st->bindValue(":login", $loginInterv);
        $res = $st->execute();
        echo $res;
        if ($res) {
            return res;
        }
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSite($codeSite, $nomSite, $codePostal, $ville, $adresse, $latitude, $longitude) {
        $req = "insert into Site(codeSite, nomSite, codePostal, ville, adresse, latitude, longitude) values (:cs, :nom, :cp, :ville, :adresse, :lat, :longi)";
        $st = $this->pdo->prepare($req);
        $st->bindValue(":cs", $codeSite);
        $st->bindValue(":nom", $nomSite);
        $st->bindValue(":cp", $codePostal);
        $st->bindValue(":ville", $ville);
        $st->bindValue(":adresse", $adresse);
        $st->bindValue(":lat", $latitude);
        $st->bindValue(":longi", $longitude);
        $res = $st->execute();
        if ($res) {
            return res;
        }
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateSite($codeSite, $nomSite, $codePostal, $ville, $adresse, $latitude, $longitude, $oldCS) {
        $req = "UPDATE Site set codeSite = :cs , nomSite = :nom , codePostal = :cp , ville = :ville , adresse = :adresse , latitude = :lat , longitude = :longi WHERE codeSite = :oldCS";
        $st = $this->pdo->prepare($req);
        $st->bindValue(":cs", $codeSite);
        $st->bindValue(":nom", $nomSite);
        $st->bindValue(":cp", $codePostal);
        $st->bindValue(":ville", $ville);
        $st->bindValue(":adresse", $adresse);
        $st->bindValue(":lat", $latitude);
        $st->bindValue(":longi", $longitude);
        $st->bindValue(":oldCS", $oldCS);
        $res = $st->execute();
        if ($res) {
            return res;
        }
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delSite($codeSite) {
        $req = "DELETE FROM Site WHERE  codeSite = :cs";
        $st = $this->pdo->prepare($req);
        $st->bindValue(":cs", $codeSite);
        $res = $st->execute();
        echo $res;
        if ($res) {
            return res;
        }
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

}

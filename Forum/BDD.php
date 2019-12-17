<?php

class Database {
    
    function Connection() {

        try {
            $pdo = new PDO("mysql:host=mysql-acapdepont.alwaysdata.net;dbname=acapdepont_php", '196105_root', '123Root654');
            // set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         //   echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $pdo;
    }

    function Check_Identification($Pseudo,$Pass) {
        $stmt = $pdo->prepare('select nickname, password from Utilisateur
 where nickname = ? and password=? ');
        $stmt->execute([$Pseudo,$Pass]);
        $resul = $stmt->fetchAll();
        
        return $resul;
    }
    
    function Check_inscription($email,$nickname) {
        $stmt = $pdo->prepare('select email, nickname from Utilisateur
 where email = ? and nickname = ? ');
        $stmt->execute([$email,$nickname]);
        $resul = $stmt->fetchAll();
        
        return $resul;
    }

    function InsertUser($name,$firstname,$nickname,$email,$password) {
        
        $check = Check_inscription($email,$nickname);
        if(count($check) >= 1){
            return "Erreur, ce compte existe déjà";
        }else{
$stmt = $this->Connection()->prepare('insert into Utilisateur'
        . ' (name, firstname, nickname,email, `password)'
        . ' values(?,?,?,?,?) ');
        $stmt->execute([$name,$firstname,$nickname,$email,$password]);
    return "Compte créer";
  
        }
        

    }

    function GetPseudolist() {

        $stmt = $this->Connection()->prepare('select distinct Pseudo
          from utilisateurchatbox');
        $stmt->execute();
        $resul = $stmt->fetchAll();

        return $resul;
    }

    function AddLine($Pseudo, $Texts) {
        $date = date("d/m");
        //       $req='insert into utilisateur  (`Pseudo`,`Texts`,`Date`)
        //               values("'.$Pseudo.'","'.$Texts.'","'.$date.'"';
        $req2 = "insert into utilisateurchatbox  (`Pseudo`,`Texts`,`Date`)"
                . "values('?','?','?')";
        $stmt = $this->Connection()->prepare("insert into utilisateurchatbox  (Pseudo,Texts,Date)"
                . "values(?,?,?)");
        //      $stmt = $this->Connection()->prepare($req);
        $stmt->execute([$Pseudo, $Texts, $date]);
        //       $stmt->execute();
    }

}

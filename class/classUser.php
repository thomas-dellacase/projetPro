<?php
require 'db.php';

class User{
    public $id;
    public $login;
    public $password;
    public $nom;
    public $prenom;
    public $email;
    public $idDroit;


    function __construct(){
        $this->db=connect();
    }

//-----------------------------------------------------------------------------------------------------------------------//
public function user_inscription($login,$password,$password2,$nom,$prenom,$email) {

    $login=htmlspecialchars($_POST['login'], ENT_QUOTES, "ISO-8859-1"); 
    $password=htmlspecialchars($_POST['password'], ENT_QUOTES, "ISO-8859-1"); 
    $password2=htmlspecialchars($_POST['password2'], ENT_QUOTES, "ISO-8859-1"); 
    $nom=htmlspecialchars($_POST['nom'], ENT_QUOTES, "ISO-8859-1"); 
    $prenom=htmlspecialchars($_POST['prenom'], ENT_QUOTES, "ISO-8859-1"); 
    $email=htmlspecialchars($_POST['email'], ENT_QUOTES, "ISO-8859-1");

    $sign_up=$this->db->prepare("SELECT pseudo FROM utilisateurs WHERE pseudo = :login ");
    $sign_up->bindValue(':login',$login);
    $sign_up->execute();
    $userExists =$sign_up->rowcount();

    $verif=$sign_up->fetchAll(PDO::FETCH_ASSOC);

    if($userExists==1){
        $message="ce nom d'utilisateur existe déjà";
    }
    
    elseif(strlen($_POST['password'])>=6){
        if($password==$password2){
            $password=password_hash($password,PASSWORD_DEFAULT);
            $sqlinsert="INSERT INTO utilisateurs(pseudo,mdp,nom,prenom,email,id_droits) VALUES(:login,:password,:email,:nom,:prenom,:value)";
            $sign_up=$this->db->prepare($sqlinsert);
            $sign_up->execute(array(
                ':login' =>$login,
                ':password'=>$password,
                ':email'=>$email,
                ':nom'=>$nom,
                ':prenom'=>$prenom,
                ':value'=>'1'
            ));
            //header("Location: connexion.php");
        }
        else $message="Les mots de passe ne sont pas identiques";
    }
    else $message= "Le mot de passe est trop court !";       
}
//---------------------------------------connection--------------------------------------//
function connect_user($login,$password,$password2){

    $login=htmlspecialchars($_POST['login'], ENT_QUOTES, "ISO-8859-1"); 
    $password=htmlspecialchars($_POST['password'], ENT_QUOTES, "ISO-8859-1");
    $password2=htmlspecialchars($_POST['password2'], ENT_QUOTES, "ISO-8859-1");
    
    if($password != $password2){
        $message="Les mots de passe ne sont pas identiques";
    }
    else{
        $password=password_hash($password,PASSWORD_DEFAULT);
        $sign_up=$this->db->prepare("SELECT * FROM utilisateurs WHERE pseudo = :login ");
        $sign_up->bindValue(':login',$login);
        $sign_up->execute();

        $verif=$sign_up->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['user']=$verif;
}
}

public function userUpdate($login,$password,$password2,$nom,$prenom,$email) {

    $login=htmlspecialchars($_POST['login'], ENT_QUOTES, "ISO-8859-1"); 
    $password=htmlspecialchars($_POST['password'], ENT_QUOTES, "ISO-8859-1"); 
    $password2=htmlspecialchars($_POST['password2'], ENT_QUOTES, "ISO-8859-1"); 
    $nom=htmlspecialchars($_POST['nom'], ENT_QUOTES, "ISO-8859-1"); 
    $prenom=htmlspecialchars($_POST['prenom'], ENT_QUOTES, "ISO-8859-1"); 
    $email=htmlspecialchars($_POST['email'], ENT_QUOTES, "ISO-8859-1");

    $sign_up=$this->db->prepare("SELECT pseudo FROM utilisateurs WHERE pseudo = :login ");
    $sign_up->bindValue(':login',$login);
    $sign_up->execute();
    $userExists =$sign_up->rowcount();

    $verif=$sign_up->fetchAll(PDO::FETCH_ASSOC);

    if($userExists==1){
        $message="ce nom d'utilisateur existe déjà";
    }
    
    elseif(strlen($_POST['password'])>=6){
        if($password==$password2){
            $password=password_hash($password,PASSWORD_DEFAULT);
            $sqlinsert="UPDATE `utilisateurs` SET `nom`=:nom,`prenom`=:prenom,`email`=:email WHERE id=:id";
            $sign_up=$this->db->prepare($sqlinsert);
            $sign_up->execute(array(
                ':login' =>$login,
                ':password'=>$password,
                ':email'=>$email,
                ':nom'=>$nom,
                ':prenom'=>$prenom,
                ':value'=>'1'
            ));
            //header("Location: connexion.php");
        }
        else $message="Les mots de passe ne sont pas identiques";
    }
    else $message= "Le mot de passe est trop court !";       
}

//----------------------------------disconnect-----------------------------------------//
function disconnect(){
    session_destroy();
    //header("Location: connexion.php");

}
}

?>
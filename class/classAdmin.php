<?php

require 'db.php';

class Admin{
    public $id;
    public $nom;
    public $prenom;

    function __construct(){
        $this->db=connect();
    }
    
    public function updateRight($idDroit,$id){
        $updateUser = $this->db->prepare("UPDATE `user` SET `id_droits`=:id_droits WHERE id=:id");
        $updateUser->execute(array(
            ':id_droits' => $idDroit,
            ':id' => $id
            ));
        
        }

    public function modUser(){
        if(isset($_POST['modUser'])){
            $mod = new Admin;
            $mod->updateRight($_POST['idRight'], $_POST['idUserRight']);
                //header ('Location:./Admin');
            }
        }



}



?>
<?php
require 'db.php';

class Produit{
    public $id;
    public $nom;
    public $description;
    public $idCategories;
    public $prix;
    public $image;


    function __construct(){
        $this->db=connect();
    }
//----------------------------------------------------------------count products ----------------------------------------------------------------
public function countProd(){
    $count = $this->db->prepare("SELECT * FROM produits");
    $count->execute();
    $result= $count->rowCount();
    //var_dump($result);
    return $result;
}
//insrt product
public function insertProd($nom,$description,$idCategories,$prix,$image){
    $insertProd = $this->db->prepare("INSERT INTO `produits`(`nom`, `description`, `idCategories`, `prix`, `image`) VALUES (:nom,:description,:idCategories,:prix,:image)");
    $insertProd->bindValue(':nom',$nom, PDO::PARAM_STR);
    $insertProd->bindValue(':description',$description, PDO::PARAM_STR);
    $insertProd->bindValue(':idCategories',$idCategories, PDO::PARAM_STR);
    $insertProd->bindValue(':prix',$prix, PDO::PARAM_STR);
    $insertProd->bindValue(':image',$image, PDO::PARAM_STR);
    $insertProd->execute();
}
//--------------------------------------Ajout Produits----------------------------------------------//
//create product 
public function addProd(){
    
    if(isset($_POST['createProd'])){
        $count = new Produit;
        $compter = $count->countProd($_POST['nom']);
        var_dump($compter);
        if($compter > 0){
            $results = "Ce nom de produit existe deja.";
            echo $results;
            return $results;
        }else{
        $create = new Produit;
        $create->insertProd(htmlspecialchars($_POST['nom']),htmlspecialchars($_POST['description']),htmlspecialchars($_POST['idCategories']),htmlspecialchars($_POST['prix']),htmlspecialchars($_POST['image']));
        }
    }

}
//----------------------------------------------------------------delete product---------------------------//
public function deleteProd($id){
    $deleteProd = $this->db->prepare("DELETE FROM `produits` WHERE `id` = :id");
    $deleteProd->bindValue(':id',$id, PDO::PARAM_STR);
    $deleteProd->execute();
}

//----------------------------------------------------------------update product---------------------------//
public function updateProd($id,$nom,$description,$idCategories,$prix,$image){
    $updateProd = $this->db->prepare("UPDATE `produits` SET `nom`=:nom,`description`=:description,`idCategories`=:idCategories,`prix`=:prix,`image`=:image WHERE `id`=:id");
    $updateProd->bindValue(':id',$id, PDO::PARAM_STR);
    $updateProd->bindValue(':nom',$nom, PDO::PARAM_STR);
    $updateProd->bindValue(':description',$description, PDO::PARAM_STR);
    $updateProd->bindValue(':idCategories',$idCategories, PDO::PARAM_STR);
    $updateProd->bindValue(':prix',$prix, PDO::PARAM_STR);
    $updateProd->bindValue(':image',$image, PDO::PARAM_STR);
    $updateProd->execute();
}
//----------------------------------------------------------------
public function getAllInfos($id){
    $getAllInfos = $this->db->prepare("SELECT * FROM produits WHERE id = :id");
    $getAllInfos->bindValue(':id', $id, PDO::PARAM_STR);
    $getAllInfos->execute();
    $result=$getAllInfos->fetchall(PDO::FETCH_ASSOC);
    return $result;
}
//--------------------------------------
public static function oldInfo(){

    if(isset($_POST['upSelect'])){
        $getInfo = new Produit();
        $info = $getInfo->getAllInfos($_POST['upSelect']);
        // echo'<pre>';
        // var_dump($info);
        // echo '</pre>';
        if(empty($_POST['nom'])){
            $_POST['nom'] = $info[0]['nom'];
        }if(empty($_POST['upDescription'])){
            $_POST['upDescription'] = $info[0]['description'];
        }if(empty($_POST['upIdSousCat'])){
            $_POST['upIdSousCat'] = $info[0]['id_sous_categories'];
        }if(empty($_POST['idCateg'])){
            $_POST['idCateg'] = $info[0]['id_categories'];
        }if(empty($_POST['upPrix'])){
            $_POST['upPrix'] = $info[0]['prix'];
        }//elseif(empty($_POST['image'])){
        //     $_POST['image'] = $info[0]['image'];
        // }
    }
    // echo'<pre>';
    // var_dump($_POST);
    // echo '</pre>';
}
//----------------------------------------------------------------
public static function updateProduct(){
    if(isset($_POST['updateProd'])){
        //echo'coucou22';
        $insert = new Produit();
        $insert->oldInfo();
        $insert = new Produit();
        $insert->oldInfo();
        $insert = new Produit();
        $insert->updateProd(htmlspecialchars($_POST['upSelect']), htmlspecialchars($_POST['idCateg']),
        htmlspecialchars($_POST['upIdSousCat']),htmlspecialchars($_POST['nom']), 
        htmlspecialchars($_POST['upDescription']),
        htmlspecialchars($_POST['upPrix']));
    }

}



}
?>
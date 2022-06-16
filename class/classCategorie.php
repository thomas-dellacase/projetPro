<?php
require 'db.php';

class Categorie{
    public $id;
    public $nom;
    public $description;
    public $idCategories;
    public $prix;
    public $image;


    function __construct(){
        $this->db=connect();
    }
//----------------------------------------Ajouts categorie-----------------------------------------//
public static function addCat(){
    if(isset($_POST['createCat'])){
        $count = new Categorie;
        $compter = $count->countCat($_POST['catName']);
        var_dump($compter);
        if($compter > 0){
            $results = "Ce nom de categories existe deja.";
            echo $results;
            return $results;
        }else{
        $create = new Categorie;
        $create->insertCat(htmlspecialchars($_POST['catName']));
        }
    }
}
//--------------------------------------inserCat--------------------------------------------------//
public function insertCat($nom){
    $nom = $_POST['nom'];
    $insertCat = $this->db->prepare("INSERT INTO `categories`(`nom`) VALUES (:nom)");
    $insertCat->bindValue(':nom',$nom, PDO::PARAM_STR);
    $insertCat->execute();
}
//-----------------------------------------------Count categories------------------------------------------------------------------------------------------------------------------------------------
public function countCat($nom){
    $count = $this->db->prepare("SELECT * FROM categories WHERE `nom` = :nom");
    $count->bindValue(':nom', $nom, PDO::PARAM_STR);
    $count->execute();
    $result= $count->rowCount();
    //var_dump($result);
    return $result;
}
//-----------------------------------------------get category------------------------------//
public function getCat(){
    $getCat = $this->db->prepare("SELECT * FROM categories");
    $getCat->execute();
    $result = $getCat->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($result);
    return $result;
}
//-------------------------------------------------------display select CAT -----------------//
public static function displayCat(){
    $choice = new Categorie();
    $tab = $choice->getCat();
    // echo '<pre>';
    // var_dump($tab);
    // echo '</pre>';
    //var_dump($tab);
    foreach($tab as $values){
        echo '<option value="' . $values['id'] . '">' . $values['nom'] . '</option>';
        //return $result;
        
    }
}
//------------------------------delete categ ------------------------------------------------//
public static function deleteCateg(){
    if(isset($_POST['deleteCat'])){
        $delete = new Categorie;
        $delete->deleteCategories(htmlspecialchars($_POST['idDel']));
        header ('Location:./Admin');
    }
} 
public function deleteCategories($id){
    $delete = $this->db->prepare("DELETE FROM categories WHERE id = :id");
    $delete->bindValue(':id', $id, PDO::PARAM_STR);
    $delete->execute();
}
}
?>
<?php
//class cart
class Cart{
    public $id;
    public $nom;
    public $idUser;
    public $adresse;
    public $postCode;
    public $date;
    public $dateExec;
    public $total;

    function __construct(){
        $this->db=connect();
    }
    public function panierEmpty(){
        if(!isset($_SESSION['panier'])){
            $_SESSION['panier']= [];
        }
    }
// panier en session 
    public function panier(){
        if(isset($_SESSION['panier'])){
            $panier = $_SESSION['panier'];
            return $panier;
        }
    }
// ajout d'un produit au panier
    public function addProd($id,$nom,$prix){
        if(isset($_SESSION['panier'])){
            $panier = $_SESSION['panier'];
            $panier[$id] = array('id'=>$id,'nom'=>$nom,'prix'=>$prix);
            $_SESSION['panier'] = $panier;
        }else{
            $panier[$id] = array('id'=>$id,'nom'=>$nom,'prix'=>$prix);
            $_SESSION['panier'] = $panier;
        }
    }
// supprimer un produit du panier    
    public function deleteProd($id){
        if(isset($_SESSION['panier'])){
            $panier = $_SESSION['panier'];
            unset($panier[$id]);
            $_SESSION['panier'] = $panier;
        }
    }
// calcul du total du panier
    public function totalPanier(){
        $total = 0;
        if(isset($_SESSION['panier'])){
            $panier = $_SESSION['panier'];
            foreach($panier as $key => $value){
                $total += $value['prix'];
            }
        }
        return $total;
    }
// calcul du nombre de produit dans le panier 
    public function countProd(){
        $count = 0;
        if(isset($_SESSION['panier'])){
            $panier = $_SESSION['panier'];
            foreach($panier as $key => $value){
                $count++;
            }
        }
        return $count;
    }
// afficher le panier
    public function showPanier(){
        if(isset($_SESSION['panier'])){
            $panier = $_SESSION['panier'];
            return $panier;
        }
    }
// afficher le panier en html
    public function showPanierHtml(){
        if(isset($_SESSION['panier'])){
            $panier = $_SESSION['panier'];
            foreach($panier as $key => $value){
                echo '<tr>';
                echo '<td>'.$value['nom'].'</td>';
                echo '<td>'.$value['prix'].'</td>';
                echo '<td><a href="?action=delete&id='.$value['id'].'">Supprimer</a></td>';
                echo '</tr>';
            }
        }
    }
}
?>
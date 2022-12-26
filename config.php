<?php

class crud{

    public static function connect(){
        try{

        $con=new PDO('mysql:localhost=localhost;dbname=php_validation','root','');

        // echo "succesfoly";
        return $con;

    }catch(PDOException $error){

        echo 'the error ' . $error->getMessage();


    }
   
}
public static function selectData(){
    $data = array();
    $con=crud::connect()->prepare("SELECT * FROM users");
    $con->execute();
    $data= $con->fetchAll(PDO::FETCH_ASSOC);
    return    $data;
}
public static function delete(){
    $con=crud::connect()->prepare("UPDATE users SET is_deleted = '1' WHERE id = :id");
    return    $con;
}

}
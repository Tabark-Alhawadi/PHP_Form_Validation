<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>register</title>
</head>
<body>

<?php require('./config.php');?>
<?php

if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $number=$_POST['number'];
    $password=$_POST['password'];
    $repassword=$_POST['re-password'];
    $datee=$_POST['date'];
    // echo($datee) ;
   
    // check birthday date
    $date=date_create($_POST['date']); // burthday date
    $nowdate=date_create("now");  // now date
    $diff= date_diff( $date,  $nowdate); // difference between burthday date and now date = (The person's age an object)
    // print_r( $diff);
    $age=$diff->y; // age user / The person's age in years
    // echo $age;

    $one=0;
    $two=0;
    $three=0;
    $four=0;
    $five=0;
    $six=0;
    $siven=0;
    $error_name="";
    $error_email="";
    $error_number="";
    $error_password="";
    $error_repassword="";
    $error_age="";
    $email_exist="";
//==================
$email_check=array();

$dd=crud::selectData();
foreach($dd as $value){
    array_push( $email_check , $value['email']);

}   
if(in_array(  $email , $email_check)){
     $email_exist = "this email is exist";
}
else{
    $siven=1;

}

//==================

if(preg_match("/^[A-Z a-z]+$/",$_POST['name'])&&!empty($_POST['name'])){
    $name = $_POST['name'];
    $one=1;

} else {
    $error_name= 'Your first name should contain just alphabets'."<br>";
}

if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)&&!empty($_POST['email'])){
$email = $_POST['email'];
$two=1;
} else {
    $error_email= 'Your email is invalid'."<br>";
}
if(preg_match("/^[0-9\-\+]{14}$/",$_POST['number'])&&!empty($_POST['number'])){
    $number = $_POST['number'];
    $five=1;

} else {
    $error_number= 'phone number Should be 14 digits'."<br>";
}
if(preg_match(("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/"), $_POST['password'])&&!empty($_POST['password'])){
$password = $_POST['password']; 
$three=1;
} else {

$error_password ='Your password is week'."<br>";
}
if(  $password ==  $repassword ){
    $four=1;

}else{
    $error_repassword= 'Your password is not match'."<br>";

}
if( $age >= 16 ){
    $six=1;

}else{
    $error_age= 'Sorry your age is under the minimum.'."<br>";

}
if( $one==1 && $two==1 && $three==1 &&  $four==1 &&  $five==1 &&  $six==1 &&  $siven==1){
    $db = crud::connect()->prepare("INSERT INTO users (id,full_name,email,password,phone_number,burthday_date) VALUES (NULL,:fname,:email,:pass,:phone,:date)");
    $db->bindValue(':fname' , $name);
    $db->bindValue(':email' , $email);
    $db->bindValue(':pass' , $password);
    $db->bindValue(':phone' , $number);
    $db->bindValue(':date' , $datee);
    $db -> execute();
    header("location:./login.php");
    exit;
    // echo 'Successfully'."<br>";

}else{
    // echo 'not Successfully'."<br>";

}};
?>

<div class="container">

<h3>CREATE ACCOUNT</h3>
<form action="" method="post" enctype="multipart/form-data" id="form">
    <input type="text" name="name" placeholder="first name">
    <?php 
    if( !empty ($error_name) ){
        echo "<p>$error_name</p>";
    }
    ?>
    <input type="email" name="email" placeholder="Email">
    <?php 
    if( !empty($error_email) ){
        echo "<p>$error_email</p>";
    }
    if( !empty($email_exist) ){
        echo "<p>$email_exist</p>";
    }
    ?>
    <input type="number" name="number" placeholder="Phone number">
    <?php 
    if(  !empty($error_number)){
        echo "<p>$error_number</p>";
    }
    ?>
    <input type="password" name="password" placeholder="password">
    <?php 
    if(  !empty($error_password)){
        echo "<p>$error_password</p>";
    }
    ?>
    <input type="password" name="re-password" placeholder="confirm password">
    <?php 
    if(  !empty($error_repassword)){
        echo "<p>$error_repassword</p>";
    }
    ?>
    <input type="date" name="date">
    <?php 
    if(  !empty($error_age)){
        echo "<p>$error_age</p>";
    }
    ?>
    <input type="submit" name="submit" value="register">
    <p id="para">Do you have an account?<a href="./login.php" >Login</a></p>

</form>
    </div>
</body>
</html>
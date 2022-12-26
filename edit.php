<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Edit data</title>
</head>
<body>

<?php require('./config.php');?>
<?php ?>
<?php
$id=$_GET['id'];
// get data from DB use id
$db = crud::connect()->prepare("SELECT * FROM users WHERE id= $id"); 
$db->execute();
$data= $db->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $number=$_POST['number'];
    $password=$_POST['password'];
    $repassword=$_POST['re-password'];

$one=0;
$two=0;
$three=0;
$four=0;
$five=0;
if(preg_match("/^[A-Z a-z]+$/",$_POST['name'])&&!empty($_POST['name'])){
    $name = $_POST['name'];
    $one=1;

} else {
    echo 'Your first name should contain just alphabets'."<br>";
}

if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)&&!empty($_POST['email'])){
    $email = $_POST['email'];
    $two=1;
} else {
    echo 'Your email is invalid'."<br>";
}
if(preg_match("^[0-9\-\+]{14}$",$_POST['number'])&&!empty($_POST['number'])){
    $number = $_POST['number'];
    $five=1;

} else {
    echo 'phone number Should be 14 digits'."<br>";
}
if(preg_match(("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/"), $_POST['password'])&&!empty($_POST['password'])){
$password = $_POST['password']; 
$three=1;
} else {
echo $_POST['password'];
echo 'Your password is week'."<br>";
}
if(  $password ==  $repassword ){
    $four=1;
}else{
    echo 'Your password is not match'."<br>";

}
if( $one==1 && $two==1 && $three==1 &&  $four==1 &&  $five==1){
    $sql = "UPDATE users SET full_name=:fname, email=:email, password=:pass WHERE id=:id";
    $db = crud::connect()->prepare($sql );
    $db->bindValue(':fname' , $name);
    $db->bindValue(':email' , $email);
    $db->bindValue(':pass' , $password);
    $db -> bindValue(':id',$id);
    $db -> execute();
    echo 'Successfully'."<br>";
    header("location:./users.php");
exit();

}else{
    echo 'not Successfully'."<br>";

}};
?>
<div class="container">

<h3>EDIT DATA </h3>
<form action="" method="post" enctype="multipart/form-data" id="form">
    <input type="text" name="name" placeholder="first name" value="<?php echo $data['full_name'];?>">
    <?php 
    if( !empty ($error_name) ){
        echo "<p>$error_name</p>";
    }
    ?>
    <input type="email" name="email" placeholder="Email" value="<?php echo $data['email'];?>">
    <?php 
    if( !empty($error_email) ){
        echo "<p>$error_email</p>";
    }
    if( !empty($email_exist) ){
        echo "<p>$email_exist</p>";
    }
    ?>
    <input type="number" name="number" placeholder="Phone number" value="<?php echo $data['phone_number'];?>">
    <?php 
    if(  !empty($error_number)){
        echo "<p>$error_number</p>";
    }
    ?>
    <input type="password" name="password" placeholder="password" value="<?php echo $data['password'];?>">
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
    <input type="date" name="date" >
    <?php 
    if(  !empty($error_age)){
        echo "<p>$error_age</p>";
    }
    ?>
    <input type="submit" name="submit" value="edit">

</form>
    </div>

</body>
</html>
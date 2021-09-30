<?php
$name = $_POST['name'];
$phonenumber = $_POST['phno'];
$email = $_POST['email'];
$description = $_POST['message'];

if(!empty($name)||!empty($phonenumber)||!empty($email)||!empty($description))
{
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "project2";
    $conn = new mysqli($host, $dbusername, $dbpassword,  $dbname);


    if(mysqli_connect_error())
    {
        die('connect error('. mysqli_connect_errno().')'. mysqli_connect_error());
    }
    else
    {
        $SELECT="SELECT email From contact_us Where email = ? Limit 1";
        $INSERT="INSERT INTO contact_us(name,phno,email,message) values(?,?,?,?)";  
        $stmt=$conn->prepare($SELECT);
        $stmt->bind_param("s" ,$email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum=$stmt->num_rows;

        if($rnum==0)
        {
            $stmt->close();

            $stmt=$conn->prepare($INSERT);
            $stmt->bind_param("siss", $name, $phonenumber, $email, $description);
            $stmt->execute();
            echo"new record inserted succecssfully";
        }
        else
        {
            echo"someone already registered using this email";
        }
        $stmt->close();
        $conn->close();    
    }

}
else
{
    echo"all field are required";
    die();
}
?>
<?php
include "auth.php";
include "../db.php";
if(isset($_POST))
	{
        $newpass = pvalidate($_POST['newpass']);
        $cpass = pvalidate($_POST['cpass']);
        
        $options = [
        'cost' => 11,
        ];
        
        $hashed = password_hash($newpass, PASSWORD_BCRYPT, $options);
                 
        
        if($newpass!=$cpass){
            echo "<div class='alert alert-danger'>
                          <strong>Error!</strong> Passwords Doesn't Match!!
                    </div>";
        }
       else
         {
                $query1 = "UPDATE admins SET password='$hashed' WHERE email ='$admin'";
                if(mysqli_query($conn, $query1)){
                    echo "<div class='alert alert-success'>
                          <strong>Success!</strong> Password Updated!!
                    </div>";
                }else{
                    echo "Opps There is some error";
                }
            }

        
}
        

function pvalidate($value){
include "../db.php";
$value = mysqli_real_escape_string($conn, $value);
return $value;
}









?>



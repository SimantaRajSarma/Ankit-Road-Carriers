<?php

$servername="localhost";

$username="u782203485_Ankit772";

$password="ARC@737373_Road";

$dbname="u782203485_ankitroad";

$conn=mysqli_connect($servername,$username,$password,$dbname);

if($conn)

{

    echo"";

}

else

{

    die("error in connection".mysqli_connect_error());

}



?>




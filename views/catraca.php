

<?php

    include '../models/db.php';
    include '../models/catraca_m.php';
    
    $conn = conectaBanco();
?>

<html>

<head>
    <title> Catraca </title>
</head>


<body>
    Sistema de catraca

    <form action="" method="post" >
            <input type="submit" name="entrar" value="Entrar">
    </form>
</body>

</html>



<?php

    if(isset($_POST['entrar'])) {

            
        entrada($conn);       
    }
?>

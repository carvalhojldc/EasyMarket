
<?php
    session_start();
    session_destroy();
    header("Location: ../views/index.php"); // redirecionando a pagina
?>

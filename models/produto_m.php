
<?php

    function getDadosProd($conn, $codigo) {

        $sql = "SELECT * FROM produto WHERE codigo='$codigo' AND statusProduto!='0'";

        $run= mysqli_query($conn, $sql);

        return $run;
    }

    function updateProd($codigo, $conn) {

        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $estoque = $_POST['estoque'];

        $sql = "UPDATE produto SET descricao='$descricao', preco='$preco', estoque='$estoque'
                WHERE codigo='$codigo' AND statusProduto!='0'";
        $run = mysqli_query($conn, $sql);

        if($run) {
            echo "<script> alert('Atualização realizada com sucesso.') </script>";

            return 1;
        }

        return 0;

    }

    function deleteProd($codigo, $conn) {
        /*
         * Omitir produto deletado,
         * definir statusProduto como 0
         */

        $query = "UPDATE produto SET statusProduto='0' WHERE codigo='$codigo' ";

        $run = mysqli_query($conn, $query);

        if($run) {
            echo "<script> alert('Produto excluído.') </script>";
        }
    }

    function listarProd($conn) {

        /*
         * Listar produtos cadastrados
         * no sistema
         */

        $prodQuery = "SELECT * FROM produto WHERE not statusProduto='0' ORDER BY descricao";

        $run= mysqli_query($conn, $prodQuery);

        return $run;
    }

?>

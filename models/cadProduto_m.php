

<?php

	/*
		Cadastro de produtos
		---
	*/

    include '../models/db.php';

    function cadastraProd() {

        $descricaoProd 	= $_POST['descricaoProd'];
        $codigo 	= $_POST['codigo'];
        $preco 		= $_POST['preco'];

        if( empty( $_POST['estoque'] ) ) {
        	/* Se o campo estoque está vazio, podemos assimir que é um
        	produto que não possui a necessidade de estoque
        		Ex: Bife à Parme...
        	*/
            $estoque = '-'; /* Estoque tipo */
        } else {
            $estoque = $_POST['estoque'];
        }

        $statusProduto = '1'; /* Produto existe em 1, recebe 0 quando é deletado */
        $produtoExluido = '0';

        $conn = conectaBanco();

        $sql = "SELECT * FROM produto WHERE codigo='$codigo' AND statusProduto!='$produtoExluido'";
        $codigo_query = mysqli_query($conn, $sql);

        if ( !mysqli_num_rows($codigo_query) ) { /* Verificando se já não existe um produto com este código */

            $insert_prod = "INSERT INTO produto (descricao, codigo, preco, estoque, statusProduto) "
                . "VALUE ('$descricaoProd', '$codigo', '$preco', '$estoque', '$statusProduto')";

            if(mysqli_query($conn, $insert_prod)) {

                mysqli_close($conn);
                echo "<script>alert('Produto cadastrado com sucesso!')</script>";

                return 1;
            }
        }

        mysqli_close($conn);
        echo "<script>alert('ERRO! Código de identificação ($codigo) já cadastrado!')</script>";
        return 0;

    }

?>

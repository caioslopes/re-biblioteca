<?php 
    $id_livro = null;

    if(!empty($_GET['id_livro'])){
        $id_livro = $_GET['id_livro'];

        date_default_timezone_set('America/Sao_Paulo');

  
        // Store datetime in variable today
        $today = new DateTimeImmutable();   
        $dia = new DateInterval('P1D'); 
        $soma = $today->add($dia);
        $amanha = $soma->format('d/m/Y');
        $hoje = $today->format('d/m/Y');

/*         echo "<pre>"; print_r($amanha); echo "</pre>"; 
        echo "<pre>"; print_r($hoje); echo "</pre>";  */
        
/*         if (!empty($amanha) &&  !empty($hoje)) { 
            $sqlInsert = $conn->prepare("INSERT INTO  teste (amanha, hoje)  VALUES('$amanha','$hoje')");
            $sqlInsert->execute();

        } else {  
            echo "erro"; 
        }; */

        $sqlSelect = $conn->prepare("SELECT titulo, nome_aluno FROM livro, aluno WHERE id_aluno = $id_aluno AND id_livro = $id_livro");
        $sqlSelect->execute();
        $resultSelect = $sqlSelect->get_result();

        foreach ($resultSelect as $dados){
            $titulo = $dados['titulo'];
            $nome_aluno = $dados['nome_aluno'];

            /* echo "<pre>"; print_r($dados); echo "</pre>"; exit; */
        };

        if(isset($_POST['reservar'])){
            $value_livro = $_POST['livro'];
            $value_aluno = $_POST['aluno'];
            $value_hoje = $_POST['hoje'];
            $value_amanha = $_POST['amanha'];

            $sqlInsert = $conn->prepare("INSERT INTO reserva_temp (cod_livro, cod_aluno, data_hoje, data_amanha) VALUES(?, ?, ?, ?)");
            $sqlInsert->bind_param("iiss", $value_livro, $value_aluno, $value_hoje, $value_amanha);
            $sqlInsert->execute();

            header('location: perfil.php?=status=sucess');
            exit;
            /* echo "<pre>"; print_r($value_livro); echo "</pre>"; exit; */
        }
        /* echo "<pre>"; print_r($dados); echo "</pre>"; exit; */
    }else{
        echo 'Error';
    }

?>

 <section class="container-xl corpo">
    <div class="alert alert-warning" role="alert">
        Lembre-se que você apenas pode fazer a reserva de <b>um</b> livro por vez!
    </div>

    <form method="POST">
        <div class="mt-3">
            <label><?php echo $titulo ?></label>
            <input class="form-control" type="text" name="livro" value="<?php echo $id_livro ?>">
        </div>
        <div class="mt-3">
            <label><?php echo $nome_aluno ?></label>
            <input class="form-control" type="text" name="aluno" value="<?php echo $id_aluno ?>">
        </div>
        <div class="mt-3">
            <label>Data do pedido</label>
            <input class="form-control" type="text" name="hoje" value="<?php echo $hoje ?>">
        </div>
        <div class="mt-3">
            <label>Data da confirmação</label>
            <input class="form-control" type="text" name="amanha" value="<?php echo $amanha ?>">
        </div>
        <div class="mt-3">
            <input class="btn btn-primary" type="submit" name="reservar">
        </div>
    </form>
</section>
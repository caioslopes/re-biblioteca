<!-- Conteudo que mostrara os livros cadastrados no sistema -->
<style>
  .vitrine {
   display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 25px 40px;
    margin-top: 20px;
    margin-bottom: 30px;
    padding-top: 20px;
    padding-bottom: 20px;
}

.vitrine div {
    flex: 1 1 200px;
    flex-wrap: wrap;
}


.capa-livros {
    width: 100%;
    height: 250px;
    border: 3px solid;
    border-radius: 10px;
}

.vitrine__livros--texto{
  margin-top: 5px;
}

.livros:hover {
    transform: scale(1.05);
    cursor: pointer;
}

/* Paginação */
.link-pag {
    color: #23232e;
    border: 1px solid #23232e;
    padding: 10px;
    margin-left: 5px;
    border-radius: 40px;
}

.link-pag:hover {
    background-color: #23232e;
    color: white;
}

.pag-atual {
    background-color: #23232e;
    color: white;
}

.caixa-pag {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}

.caixa-pag-num {
    display: flex;
    justify-content: space-between;
}
.titulo-pagina{
    text-align: center;
    flex-direction: column;
    gap: 30px;
}
.caixa-busca{
    display: flex;
    justify-content: center;
    gap: 70px;
}
.btn-categoria{
    height: 100%;
    padding: 0px 30px;
    border-radius: 20px;
}
.caixa-categoria span{
    margin-right: 10px;
}
.nenhum-resultado{
    margin-top: 30px;
    text-align: center;
}
.titulo-pagina{
    border: unset;
}
.titulo-index{
    border-bottom: 2px solid;
}
@media (max-width: 767px){
    .vitrine{
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        padding-bottom: 20px;
    }
    .titulo-pagina{
        flex-direction: column;
        align-items: center;
    }
    .caixa-busca{
        width: 90%;
        margin-bottom: 20px;
        flex-direction: column;
        gap: 30px;
    }
    .caixa-categoria{
        order: 1;
    }
}
</style>

<?php  
    if(isset($_GET['id_categoria'])){
        $id_categoria = $_GET['id_categoria'];

        //Receber o número da página
        $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
        $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

        //Setar a quantidade de itens por pagina
        $qnt_result_pg = 12;

        //calcular o inicio visualização
        $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;
        $sql = $conn->prepare("SELECT * FROM livro WHERE cod_categoria = $id_categoria LIMIT $inicio, $qnt_result_pg");
        $sql->execute();
        $result = $sql->get_result();

        //Seleciona categoria
        $SelectCategoria = $conn->prepare("SELECT * FROM categoria");
        $SelectCategoria->execute();
        $resultCategoria = $SelectCategoria->get_result();

        //Seleciona categoria
        $SelectCategoria2 = $conn->prepare("SELECT * FROM categoria WHERE id_categoria = $id_categoria");
        $SelectCategoria2->execute();
        $resultCategoria2 = $SelectCategoria2->get_result();
   
    } 
  ?>

<section class="container-xl mt-4">
    <div class="d-flex justify-content-between titulo-pagina">
        <div class="titulo-index">
            <?php while($nomecat = mysqli_fetch_assoc($resultCategoria2)){ ?>
                <h1><?php echo $nomecat['nome_categoria'] ?></h1>
           <?php } ?>
        </div>
        <div class="caixa-busca">
            <div class="caixa-categoria">
                <span>Buscar por</span>
                <div class="btn-group">
                <button class="btn btn-secondary dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                    Categoria
                </button>
                <ul class="dropdown-menu">
                    <?php
                        while($dados = mysqli_fetch_assoc($resultCategoria)){ ?>
                            <li><a class="dropdown-item" href="categorias.php?id_categoria=<?php echo $dados['id_categoria']; ?>"><?php echo $dados['nome_categoria']; ?></a></li>
                      <?php  } ?>
                </ul>
                </div>
            </div>

            <form class="d-flex" role="search" method="GET">
                <input class="form-control me-2 rounded-pill" type="search" name="busca" placeholder="Buscar um livro..." value="<?php if (isset($_GET['busca'])){ echo $_GET['busca']; } ?>">
                <button class="btn btn-outline-primary rounded-circle" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

  <?php if(empty($_GET['busca'])){?>

    <div class="fundo__vitrine--livros mt-4">
      <section class="container-xl">
        <div class="vitrine">
          <?php while ($livros = mysqli_fetch_assoc($result)) {?>
          <div class="livros">
             <img src='img/<?php echo $livros['imagem'] ?>' class="capa-livros"  alt="Imagem da capa do livro">
             <div>
                <span><?php echo $livros['titulo'] ?></span>
             </div>
          </div>
          <?php } ?>
        </div>
      </section>
    </div>
    
      <?php 
        //Paginção - Somar a quantidade de livro
        $result_pg = $conn->prepare("SELECT COUNT(id_livro) AS num_result FROM livro WHERE cod_livro = $id_categoria");
        $result_pg->execute();
        $resultado_pg = $result_pg->get_result();

        $row_pg = mysqli_fetch_assoc($resultado_pg);
        //Quantidade de pagina 
        $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

        //Limitar os link antes depois
        $max_links = 2;

        ?>
       <div class='content caixa-pag'>
            <div class='caixa-pag-num'>
                <a class='link-pag' href='categorias.php?pagina=1'>Primeira</a>
                <?php
                for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                    if ($pag_ant >= 1) {
                        echo "<a class='link-pag' href='categorias.php?pagina=$pag_ant'>$pag_ant</a> ";
                    }
                } ?>
                <span class='link-pag pag-atual'><?php echo $pagina ?></span>
                <?php
                for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                    if ($pag_dep <= $quantidade_pg) { ?>
                        <a class='link-pag' href='categorias.php?pagina=<?php echo $pag_dep ?>'><?php echo $pag_dep ?></a> 
                <?php  }
                }

                ?>
                <a class='link-pag' href='categorias.php?pagina=<?php echo $quantidade_pg ?>'>Ultima</a>
            </div>
        </div>

    <!-- Resultado da pesquisa do usuario -->
    <?php
        }else { 
            //Pega o valor digitado pelo usuario na barra de pesquisa
            $busca = $_GET['busca'];    

            //Receber o número da página
            $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
            $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

            //Setar a quantidade de itens por pagina
            $qnt_result_pg = 12;

            //calcular o inicio visualização
            $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;
            $SelectBusca = $conn->prepare("SELECT * FROM livro WHERE titulo LIKE '%$busca%' OR autor LIKE '%$busca%' LIMIT $inicio, $qnt_result_pg");
            $SelectBusca->execute();
            $resultBusca = $SelectBusca->get_result();
        
        if($resultBusca->num_rows == 0){ ?>
                <div class="fundo__vitrine--livros mt-4">
                    <section class="container-xl">
                        <div class="nenhum-resultado">
                            <h4>Nenhum resultado encontrado... <a class="btn btn-sm btn-primary rounded-pill" href="index.php">Voltar para Livros</a></h4>
                        </div>
                    </section>
                </div>

       <?php  }else { ?>
                <div class="fundo__vitrine--livros mt-4">
                    <section class="container-xl">
                        <div class="vitrine">
                        <?php while ($livro_busca = mysqli_fetch_assoc($resultBusca)) {?>
                        <div class="livros">
                            <img src='img/<?php echo $livro_busca['imagem'] ?>' class="capa-livros"  alt="Imagem da capa do livro">
                            <div>
                                <span><?php echo $livro_busca['titulo'] ?></span>
                            </div>
                        </div>
                        <?php } ?>
                        </div>
                    </section>
                </div>
       
   <?php }} ?>
</section>
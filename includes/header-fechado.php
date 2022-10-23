<?php

  //Pega Informação aluno
 if(isset($_SESSION['id_aluno'])){
  $id_aluno = $_SESSION['id_aluno'];

  $querySelectAluno = $conn->prepare("SELECT nome_aluno, email FROM aluno WHERE id_aluno = $id_aluno");
  $querySelectAluno->execute();
  $resultSelectAluno = $querySelectAluno->get_result();

  while($aluno = mysqli_fetch_assoc($resultSelectAluno)){
      $nome_aluno = $aluno['nome_aluno'];
      $email_aluno = $aluno['email'];
  };
};

  //Pega Informação gestor
  if(isset($_SESSION['id_gestor'])){
  $id_gestor = $_SESSION['id_gestor'];

  $querySelectGestor = $conn->prepare("SELECT nome_gestor FROM gestor WHERE id_gestor = $id_gestor");
  $querySelectGestor->execute();
  $resultSelectGestor = $querySelectGestor->get_result();

  while($gestor = mysqli_fetch_assoc($resultSelectGestor)){
      $nome_gestor = $gestor['nome_gestor'];
  };
};
?>
<!-- Abrindo a pagina -->
<style>
  #abrir{
    display: block;
    border: unset;
    background: unset;
  }
  @media (max-width:767px){
    #abrir{
      color: white;
    }
    .header-fechado{
    background-color: #23232e;
  }
  }
</style>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
  </head>
  <body>
    <nav class="navbar header-geral header-fechado">
        <div class="d-flex container-xl">
          <button id="abrir" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
          </button>
        </div>
    </nav>

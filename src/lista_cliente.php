<?php
require 'cabecalho.php';

// Recebe o termo de pesquisa se existir
$termo = (isset($_GET['termo'])) ? $_GET['termo'] : '';

// Verifica se o termo de pesquisa está vazio, se estiver executa uma consulta completa
if (empty($termo)) :
    $conexao = conexao::getInstance();
    $sql = 'SELECT idcliente, nome, cpf FROM cliente';
    $stm = $conexao->prepare($sql);
    $stm->execute();
    $cliente = $stm->fetchAll(PDO::FETCH_OBJ);

else :
    // Executa uma consulta baseada no termo de pesquisa passado como parâmetro
    $conexao = conexao::getInstance();
    $sql = 'SELECT idcliente, nome, cpf FROM cliente WHERE nome LIKE :nome OR cpf LIKE :cpf';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':nome', '%' . $termo . '%');
    $stm->bindValue(':cpf', '%' . $termo . '%');
    $stm->execute();
    $cliente = $stm->fetchAll(PDO::FETCH_OBJ);

endif;
?>

<div class="container">
	<div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger">
	<footer class="page-footer red darken-4">		
	
                        <?php if (!empty($cliente)): ?>

                            <!-- Tabela de Clientes -->
	<table class="table text-white">
		<thead>
			<tr>
				<th scope="col">Matricula</th>
				<th scope="col">Nome</th>
				<th scope="col">CPF</th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
                                <?php foreach ($cliente as $cliente): ?>
           <tr>
				<td><?= $cliente->idcliente ?></td>
				<td><?= $cliente->nome ?></td>
				<td><?= $cliente->cpf ?></td>
				<td><a href='frm_cliente.php?id=<?= $cliente->idcliente ?>'
					class="btn btn-primary">Abrir Cadastro</a></td>
			</tr>	
                                <?php endforeach; ?>
                                </tbody>
	</table>
                        <?php else: ?>
                            <!-- Mensagem caso não exista clientes ou não encontrado  -->
	<h3 class="text-center">Nao existem Cliente Cadastrado com este nome ou CPF!</h3>
                        <?php endif; ?>
                        </footer>                   
                </div>
                </div>



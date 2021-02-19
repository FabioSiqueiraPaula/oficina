<?php
include '../conexao.php';

// Recebe o id do cliente do cliente via GET
$idveiculo = (isset($_GET['idveiculo'])) ? $_GET['idveiculo'] : '';

// Busca Dados Veiculos
if (! empty($idveiculo) && is_numeric($idveiculo)) :
$conexao = conexao::getInstance();
$sql = 'SELECT * FROM veiculo WHERE idveiculo = :idveiculo';
$stm = $conexao->prepare($sql);
$stm->bindValue(':idveiculo', $idveiculo);
$stm->execute();
$veiculos = $stm->fetch(PDO::FETCH_OBJ);
endif;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title>SIS CarSelect</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="../css/bootstrap.min.css" rel="stylesheet"
	id="bootstrap-css">
	
	<link href="../css/style.css" rel="stylesheet">
	
<script src="../js/bootstrap.min.js"></script>

<link href="http://fonts.googleapis.com/icon?family=Material+Icons"
	rel="stylesheet">

<link type="text/css" rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css" />

<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">

<script
	src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>

<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>

</head>
<body>
	
	<footer class="page-footer red darken-4">
		<div class="shadow-lg p-3 mb-5 bg-red rounded">
			<h4 class="text-white">Cadastro de Cliente [ Atualiza Veiculos ]</h4>
		</div>
		<?php if(empty($veiculos)) :else : ?>
		<form action="action_veiculo_cliente.php" method="post"
			class="text-white">

			<div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger">
			
			<div class="row">
					<input id="idveiculo" name="idveiculo" type="hidden"
						value="<?php  echo $veiculos-> idveiculo; ?>">					
				</div>

				<div class="row">
					<div class="input-field col s5">
						<div class="input-group input-group-mb">
							Fabricante <input type="text" name="fabricante" id="fabricante" value="<?= $veiculos->fabricante ?>
								class="form-control text-white"
								aria-label="Sizing example input"
								aria-describedby="inputGroup-sizing-mb" maxlength="20">
						</div>
					</div>
					<div class="input-field col s5">
						<div class="input-group input-group-mb">
							Modelo <input type="text" name="modelo" id="modelo" value="<?= $veiculos->modelo ?>"
								class="form-control text-white"
								aria-label="Sizing example input"
								aria-describedby="inputGroup-sizing-mb" maxlength="20">
						</div>
					</div>
					<div class="input-field col s2">
						<div class="input-group input-group-mb">
							Ano <input type="text" name="ano" id="ano" value="<?= $veiculos->ano ?>"
								class="form-control text-white"
								aria-label="Sizing example input"
								aria-describedby="inputGroup-sizing-mb" maxlength="9">
						</div>
					</div>
				</div>
				<div class="row">

					<div class="input-field col s2">
						<div class="input-group input-group-mb">
							Cor <input type="text" name="cor" id="cor" value="<?= $veiculos->cor ?>"
								class="form-control text-white"
								aria-label="Sizing example input"
								aria-describedby="inputGroup-sizing-mb" maxlength="9">
						</div>
					</div>
					<div class="input-field col s2">
						<div class="input-group input-group-mb">
							Motorização <input type="text" name="motorizacao" value="<?= $veiculos->motorizacao ?>"
								id="motorizacao" class="form-control text-white"
								aria-label="Sizing example input"
								aria-describedby="inputGroup-sizing-mb" maxlength="9">
						</div>
					</div>
					<div class="input-field col s2">
						<div class="input-group input-group-mb">
							Placa <input type="text" name="placa" id="placa" value="<?= $veiculos->placa ?>"
								class="form-control text-white"
								aria-label="Sizing example input"
								aria-describedby="inputGroup-sizing-mb" maxlength="9">
						</div>
					</div>
				</div>

				<hr />

				<div class="row">
					<div class="col 12">
						<button class="btn btn-primary btn-lg btn-block btn-danger"
							type="submit" name="action">
							<input type="hidden" name="acao" value="editar"> Salvar
						</button>
					</div>
				</div>
			</div>

		</form>
		<?php endif; ?>
		</footer>
</div>
</body>
</html>
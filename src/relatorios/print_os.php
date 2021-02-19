<?php
require_once '../../conexao.php';

$idcliente = (isset($_GET['id'])) ? $_GET['id'] : '';
$idos = (isset($_GET['idos'])) ? $_GET['idos'] : '';
$idveiculo = (isset($_GET['idveiculo'])) ? $_GET['idveiculo'] : '';

// Pega os Dados do cliente
if (empty($empresa)) :
    $conexao = conexao::getInstance();
    $sql = "SELECT * FROM empresa";
    $stm = $conexao->prepare($sql);
    $stm->execute();
    $empresa = $stm->fetchAll(PDO::FETCH_OBJ);
endif;

// Pega os Dados do cliente
if (empty($cliente)) :
    $conexao = conexao::getInstance();
    $sqlcliente = "SELECT * FROM os o
                    INNER JOIN cliente c
		ON(o.idcliente = c.idcliente)			
                    WHERE o.idos = :idos";
    $stm = $conexao->prepare($sqlcliente);
    $stm->bindValue(':idos', $idos);
    $stm->execute();
    $cliente = $stm->fetchAll(PDO::FETCH_OBJ);
endif;

// Pega o Endereco do cliente
if (empty($endereco)) :
    $conexao = conexao::getInstance();
    $sqlendereco = "SELECT e.logradouro, e.numero, e.complemento, e.bairro, e.cidade, e.uf, e.cep FROM os o
                    INNER JOIN endereco e
		ON(e.idcliente = o.idcliente)			
                    WHERE o.idos = :idos";
    $stm = $conexao->prepare($sqlendereco);
    $stm->bindValue(':idos', $idos);
    $stm->execute();
    $endereco = $stm->fetchAll(PDO::FETCH_OBJ);
endif;

// Pega o Contato do cliente
if (empty($contato)) :
    $conexao = conexao::getInstance();
    $sqlcontato = "SELECT co.telefone1, co.telefone2, co.email FROM os o
                    INNER JOIN contato co
                    ON(co.idcliente = o.idcliente)			
                    WHERE o.idos = :idos";
    $stm = $conexao->prepare($sqlcontato);
    $stm->bindValue(':idos', $idos);
    $stm->execute();
    $contato = $stm->fetchAll(PDO::FETCH_OBJ);
endif;

// Pega o Veiculo do cliente
if (empty($veiculo)) :
    $conexao = conexao::getInstance();
    $sqlveiculo = "SELECT * FROM os o
                    INNER JOIN veiculo v
                    ON(o.idveiculo = v.idveiculo)			
                    WHERE o.idos = :idos";
    $stm = $conexao->prepare($sqlveiculo);
    $stm->bindValue(':idos', $idos);
    $stm->execute();
    $veiculo = $stm->fetchAll(PDO::FETCH_OBJ);
endif;

// Pega os Itens de servicos da OS
if (empty($itens)) :
    $conexao = conexao::getInstance();
    $sqlitens = "SELECT * FROM os o
	INNER JOIN os_itens oi
	ON(oi.idos = o.idos)            
		WHERE o.idos = :idos                   
                ORDER BY oi.tipo";
    $stm = $conexao->prepare($sqlitens);
    $stm->bindValue(':idos', $idos);
    $stm->execute();
    $itens = $stm->fetchAll(PDO::FETCH_OBJ);
endif;

// Pega Total da OS
if (empty($total)) :
    $conexao = conexao::getInstance();
    $sqltotal = "SELECT * FROM os       
		WHERE idos = :idos";
    $stm = $conexao->prepare($sqltotal);
    $stm->bindValue(':idos', $idos);
    $stm->execute();
    $total = $stm->fetchAll(PDO::FETCH_OBJ);
endif;
?>


<html>
    <head>
        <meta charset="utf-8" />
        <title>SIS CarSelect</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">  

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    </head>
    <body>
        <div class="container">
            <header>
                <table class="table table-borderless">
                    <tbody>
                        <?php if (!empty($empresa)): ?>
                            <?php foreach ($empresa as $empresa): ?>
                                <tr>                        
                                    <td><img src="../img/<?= $empresa->logo ?>" height="50" width="50"></td>
                                    <td style="text-align: right;"><i class=" icon-cars" style="font-size:38px;color:red"></i><h6><?= $empresa->nomeempresa ?></h6></td>
                                </tr>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
            </header>
            <?php if (!empty($cliente)): ?>
    <?php foreach ($cliente as $cliente): ?>
            <main class="h6">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="3" style="text-align: center;">ORDEM DE SERVICO</td> 
                            </tr>
                            <tr>
                                <td><sup>Situação</sup>&nbsp;<?= $cliente->status ?></td>                                       
                                <td><sup>Numero</sup>&nbsp;<?= $cliente->idos ?> </td>
                                <td><sup>Data OS</sup>&nbsp;<?= date('d/m/Y', strtotime($cliente->dataos)) ?> </td>
                            </tr>                
                        </table>           

                        <table class="table table-bordered">

                            <tr>
                                <td colspan="3"><h8>CLIENTE</h8></td>
                            </tr>              
                            <tr>
                                <td colspan="2"><sup>Nome</sup> <?= $cliente->nome ?></td>
                                <td><sup>Cpf / CNPJ</sup> <?= $cliente->cpf ?></td>
                            </tr>
                        <?php
                        endforeach;
                    endif;
                    ?>
                    <tr>
                        <td colspan="3"><h8>ENDEREÇO</h8></td>
                    </tr>
<?php if (!empty($endereco)): ?>
    <?php foreach ($endereco as $endereco): ?>
                            <tr>
                                <td><sup>Logradouro</sup>&nbsp; <?= $endereco->logradouro ?></td>
                                <td><sup>Numero</sup> &nbsp; <?= $endereco->numero ?></td>
                                <td><sup>Complemento</sup> &nbsp; <?= $endereco->complemento ?></td>
                            </tr>
                            <tr>
                                <td><sup>Bairro</sup> &nbsp; <?= $endereco->bairro ?></td>
                                <td><sup>Cidade</sup> &nbsp; <?= $endereco->cidade ?></td>
                                <td><sup>Estado</sup> &nbsp; <?= $endereco->uf ?> &nbsp;&nbsp;<sup>CEP</sup> &nbsp; <?= $endereco->cep ?> </td>
                            </tr>
                        <?php
                        endforeach;
                    endif;
                    ?>

<?php if (!empty($veiculo)): ?>
    <?php foreach ($veiculo as $veiculo): ?>
                            <tr>
                                <td colspan="3"><h8>VEICULO</h8></td>
                            </tr>
                            <tr>
                                <td><sup>Fabricante</sup> &nbsp; <?= $veiculo->fabricante ?></td>
                                <td><sup>Modelo</sup> &nbsp; <?= $veiculo->modelo ?></td>
                                <td><sup>Ano</sup> &nbsp; <?= $veiculo->ano ?></td>
                            </tr>
                            <tr>
                                <td><sup>Motorização</sup> &nbsp; <?= $veiculo->motorizacao ?></td>
                                <td><sup>Cor</sup> &nbsp; <?= $veiculo->cor ?></td>
                                <td><sup>Placa</sup> &nbsp; <?= $veiculo->placa ?></td>
                            </tr>
    <?php
    endforeach;
endif;
?>
                </table>

                <div class="table table-bordered">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col" colspan="3">PEÇAS</th>                            
                            </tr>
                        </thead>

                        <thead>
                            <tr>
                                <th scope="col">Descrição</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Fornecedor</th>
                            </tr>
                        </thead>
<?php if (!empty($itens)): ?>
    <?php foreach ($itens as $itenspeca): ?>
        <?php if ($itenspeca->tipo == "Peca"): ?>
                                    <tr>
                                        <td><?= $itenspeca->descricao ?></td>
                                        <td>R$ <?= number_format($itenspeca->total, 2, ',', '.') ?></td>
                                        <td><?= $itenspeca->fornecedor ?></td>
                                    </tr>
                                    <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </table>

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col" colspan="2">SERVIÇOS</th>                            
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="col">Descrição</th>
                                <th scope="col">Valor</th>                            
                            </tr>
                        </thead>
<?php if (!empty($itens)): ?>
    <?php foreach ($itens as $itensserv): ?>
                                <?php if ($itensserv->tipo == "Servico"): ?>
                                    <tr>
                                        <td><?= $itensserv->descricao ?></td>
                                        <td>R$ <?= number_format($itensserv->total, 2, ',', '.') ?></td>                        
                                    </tr>
                                    <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </table>
                    <table class="table table-striped table-hover">                    
                        <thead>                        
                            <tr>
                                <?php if (!empty($total)): ?>
                                    <?php foreach ($total as $t): ?>
                                        <th scope="col"><sup>Total Peças</sup>&nbsp; R$ <?= $t->totalpecas ?></th>
                                        <th scope="col"><sup>Total Serviços</sup>&nbsp; R$ <?= $t->totalservicos ?></th>
                                        <th scope="col"><sup>Total OS</sup> &nbsp; R$ <?= $t->totalos ?></th>
    <?php
    endforeach;
endif;
?>
                            </tr>                        
                        </thead>                    
                    </table>
                </div>
            </main>
            <footer>
                <table class="table table-striped table-hover">                    
                    <thead>  
                        <tr>
                            <td>Data: _____/______/_____</td>
                            <td style="text-align: right">Rublica: ____________________________________________________________</td>
                        </tr>
                    </thead>
                </table>
            </footer>
            <table>
                <tr>
                    <td align="right">
                        <button type="button" class="btn btn-primary btn-lg btn-block" id="imprimir"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>clique aqui para imprimir</button>
                    </td>                    
                </tr>
            </table>
        </div>
       
    </body>
</html>
<script>
    window.onload = function () {
        var imprimir = document.querySelector("#imprimir");
        imprimir.onclick = function () {
            imprimir.style.display = 'none';
            window.print();

            var time = window.setTimeout(function () {
                imprimir.style.display = 'block';
                window.location.href = "../lista_cliente.php";
            }, 1000);
        }
    }    
    
</script>
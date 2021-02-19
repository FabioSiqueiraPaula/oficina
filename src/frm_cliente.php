<?php
include 'cabecalho.php';

// Recebe o id do cliente do cliente via GET
$id_cliente = (isset($_GET['id'])) ? $_GET['id'] : '';
$idos = (isset($_GET['idos'])) ? $_GET['idos'] : '';

// Busca Dados Cliente
if (!empty($id_cliente) && is_numeric($id_cliente)) :
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM cliente WHERE idcliente = :id';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':id', $id_cliente);
    $stm->execute();
    $cliente = $stm->fetch(PDO::FETCH_OBJ);
endif;

// Verefica se o cliente tem OS em ABERTO
if (!empty($id_cliente) && is_numeric($id_cliente)) :
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM cliente c 
            INNER JOIN os o
            ON(c.idcliente = o.idcliente)                                
       WHERE c.idcliente = :id AND o.status = "ABERTO"';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':id', $id_cliente);
    $stm->execute();
    $clienteos = $stm->fetch(PDO::FETCH_OBJ);
endif;

// Busca Endereco Cliente
if (!empty($id_cliente) && is_numeric($id_cliente)) :
    // Captura os dados do Aluno
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM cliente c
            INNER JOIN endereco e
            ON
                e.idcliente = c.idcliente
            WHERE
                c.idcliente = :id';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':id', $id_cliente);
    $stm->execute();
    $endereco = $stm->fetch(PDO::FETCH_OBJ);
endif;

// Busca Contato Cliente
if (!empty($id_cliente) && is_numeric($id_cliente)) :
    // Captura os dados do Aluno
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM cliente c
            INNER JOIN contato e
            ON
                e.idcliente = c.idcliente
            WHERE
                c.idcliente = :id';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':id', $id_cliente);
    $stm->execute();
    $contato = $stm->fetch(PDO::FETCH_OBJ);
endif;

// Busca Veiculos Cliente
if (empty($carros)) :
    $conexao = conexao::getInstance();
    $sqlveiculos = 'SELECT * FROM veiculo v
            INNER JOIN cliente c
            ON
                v.idcliente = c.idcliente
            WHERE
                c.idcliente = :id';
    $stm = $conexao->prepare($sqlveiculos);
    $stm->bindValue(':id', $id_cliente);
    $stm->execute();
    $carros = $stm->fetchAll(PDO::FETCH_OBJ);
endif;

// Busca Veiculos Cliente
if (empty($veiculos)) :
    $conexao = conexao::getInstance();
    $sqlveiculos = 'SELECT * FROM veiculo v
            INNER JOIN cliente c
            ON
                v.idcliente = c.idcliente
            WHERE
                c.idcliente = :id';
    $stm = $conexao->prepare($sqlveiculos);
    $stm->bindValue(':id', $id_cliente);
    $stm->execute();
    $veiculos = $stm->fetchAll(PDO::FETCH_OBJ);
endif;

// Busca OS em Aberto do Cliente
if (empty($verificaos)) :
    $conexao = conexao::getInstance();
    $sqlveros = "SELECT c.idcliente, o.idos, v.idveiculo, o.dataos, v.modelo, v.placa FROM os o 
	INNER JOIN cliente c
		ON (o.idcliente = c.idcliente)
	INNER JOIN veiculo v
		ON (o.idcliente = v.idcliente)            
	WHERE c.idcliente = :id
    AND o.status = 'ABERTO'
    GROUP BY c.idcliente";
    $stm = $conexao->prepare($sqlveros);
    $stm->bindValue(':id', $id_cliente);
    $stm->execute();
    $verificaos = $stm->fetchAll(PDO::FETCH_OBJ);
endif;
?>

<html>
    <head>

    </head>
    <body>
        <div class="container">
            <div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger">
                <footer class="page-footer red darken-4">
                    <div class="row col s12 z-depth-5">
                        <h4 id="box">Cadastro de Clientes</h4>
                    </div>

                    <?php
                    if (empty($cliente)) :else :
                        ?>				
                        <div class="row">
                            <div class="input-field col s6">
                                <h5><?= $cliente->nome ?></h5>
                            </div>
                            <div class="input-field col s6" align="right">
                                <a onclick="acao()"
                                   class="waves-effect waves-light btn modal-trigger" href="#modal1">Abrir
                                    OS</a>
                            </div>
                        </div>
                        <div class="col s12">
                            <h5 class="label">Dados Pessoais</h5>
                            <div>
                                <div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger">
                                    <div class="row">
                                        <form class="col s12" action="action_dados_aluno.php"
                                              method="post">
                                            <div class="row">
                                                <div class="input-field col s8">
                                                    Nome <input id="alunonome" name="alunonome" type="text"
                                                                class="validate fonts" value="<?= $cliente->nome ?>">
                                                </div>
                                                <div class="input-field col s1">
                                                    Matricula <input id="id" name="id" type="text"
                                                                     class="validate" value="<?= $cliente->idcliente ?>" readonly>
                                                </div>
                                                <div class="input-field col s1">
                                                    Cadastro <input id="dtcadastro" name="dtcadastro" type="text"
                                                                    class="validate" value="<?= $cliente->dtcadastro ?>" readonly>
                                                </div>
                                                <div class="input-field col s2">
                                                    Ativo <br /> <br /> <input class="with-gap" id="status"
                                                                               name="status" type="radio" /> <span>Sim</span> <input
                                                                               class="with-gap" id="status" name="group1" type="radio" /> <span>N&atilde;o</span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="input-field col s4">
                                                    Data Nascimento <input id="nascimento" name="nascimento"
                                                                           type="text" class="validate"
                                                                           value="<?= $cliente->dtnascimento ?>">
                                                </div>
                                                <div class="input-field col s4">
                                                    Sexo <input id="sexo" name="sexo" type="text" class="validate"
                                                                value="<?= $cliente->sexo ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="input-field col s4">
                                                    CPF <input id="cpf" name="cpf" type="text" class="validate"
                                                               value="<?= $cliente->cpf ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <input type="hidden" name="acao" value="editar">
                                                    <button class="btn btn-primary btn-lg btn-block btn-danger"
                                                            type="submit" name="action">Atualizar Dados</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <hr />

                        <h5>Contato</h5>
                        <div>
                            <div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger">
                                <?php if (empty($contato)) :else : ?>
                                    <form class="col s12" action="action_contato_aluno.php" method="post">
                                        <div class="row">
                                            <div class="input-field col s12">

                                                <div class="input-group input-group-lg">
                                                    Telefone 1 <input id="telefone1" name="telefone1" type="text"
                                                                      class="form-control text-white"
                                                                      value="<?= $contato->telefone1 ?>"
                                                                      aria-label="Sizing example input"
                                                                      aria-describedby="inputGroup-sizing-lg">
                                                </div>

                                            </div>
                                            <div class="input-field col s12">

                                                <div class="input-group input-group-lg">
                                                    Telefone 2 <input id="telefone2" name="telefone2" type="text"
                                                                      class="form-control text-white"
                                                                      value="<?= $contato->telefone2 ?>"
                                                                      aria-label="Sizing example input"
                                                                      aria-describedby="inputGroup-sizing-lg">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">

                                                <div class="input-group input-group-lg">
                                                    E-mail <input id="email" name="email" type="email"
                                                                  class="form-control text-white"
                                                                  value="<?= $contato->email ?>"
                                                                  aria-label="Sizing example input"
                                                                  aria-describedby="inputGroup-sizing-lg">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="hidden" name="acao" value="editar">
                                                <button class="btn btn-primary btn-lg btn-block btn-danger"
                                                        type="submit" name="action">Atualizar Dados</button>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>
                                <a href="frm_cad_contato_cliente.php?id=<?php echo $id_cliente; ?>"
                                   class="btn-floating btn-large waves-effect waves-light"><i
                                        class="material-icons">add</i></a> <label class="text-white">Adicionar
                                    Contato</label>
                            </div>
                        </div>

                        <hr />

                        <h5>Endere&ccedil;o</h5>
                        <div>
                            <div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger">
                                <?php if (empty($endereco)) :else : ?>
                                    <form class="col s12" action="action_endereco_aluno.php"
                                          method="post">
                                        <div class="row mr-auto ml-auto">
                                            <div class="col">
                                                <div class="input-group input-group-mb">
                                                    CEP <input type="text" name="cep" id="cep"
                                                               class="form-control text-white" value="<?= $endereco->cep ?>"
                                                               aria-label="Sizing example input"
                                                               aria-describedby="inputGroup-sizing-mb"
                                                               placeholder="Ex.: 00000-000"
                                                               onKeyPress="MascaraCep(formulario.cep);" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="col"></div>
                                        </div>
                                      
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group input-group-mb">
                                                    Logradouro <input type="text" name="logradouro"
                                                                      id="logradouro" value="<?= $endereco->logradouro ?>"
                                                                      class="form-control text-white mr-auto"
                                                                      aria-label="Sizing example input"
                                                                      aria-describedby="inputGroup-sizing-lg">
                                                </div>
                                            </div>
                                        </div>                                  

                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group input-group-lg">
                                                    Numero <input id="numero" name="numero" type="text"
                                                                  value="<?= $endereco->numero ?>"
                                                                  class="form-control text-white"
                                                                  aria-label="Sizing example input"
                                                                  aria-describedby="inputGroup-sizing-lg">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group input-group-lg">
                                                    Complemento <input id="complemento" name="complemento"
                                                                       type="text" value="<?= $endereco->complemento ?>"
                                                                       class="form-control text-white"
                                                                       aria-label="Sizing example input"
                                                                       aria-describedby="inputGroup-sizing-lg">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group input-group-lg">
                                                    Bairro <input id="bairro" name="bairro" type="text"
                                                                  value="<?= $endereco->bairro ?>"
                                                                  class="form-control text-white"
                                                                  aria-label="Sizing example input"
                                                                  aria-describedby="inputGroup-sizing-lg">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group input-group-lg">
                                                    Cidade <input id="cidade" name="cidade" type="text"
                                                                  value="<?= $endereco->cidade ?>"
                                                                  class="form-control text-white"
                                                                  aria-label="Sizing example input"
                                                                  aria-describedby="inputGroup-sizing-lg">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group input-group-lg">
                                                    UF <input id="uf" name="uf" type="text"
                                                              class="form-control text-white" value="<?= $endereco->uf ?>"
                                                              aria-label="Sizing example input"
                                                              aria-describedby="inputGroup-sizing-lg">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="hidden" name="acao" value="editar">
                                                <button class="btn btn-primary btn-lg btn-block btn-danger"
                                                        type="submit" name="action">Atualizar Dados</button>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>						
                                <a href="frm_cad_end_cliente.php?id=<?php echo $id_cliente; ?>"
                                   class="btn-floating btn-large waves-effect waves-light"><i
                                        class="material-icons">add</i></a> <label class="text-white">Adicionar
                                    Endere&ccedil;o</label>
                            </div>
                        </div>
                        <hr />

                        <h5>Carros</h5>
                        <div>
                            <div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger">
                                <footer class="page-footer red darken-4">
                                    <table class="table text-white">
                                        <thead>
                                            <tr>
                                                <th scope="col">Fabricante</th>
                                                <th scope="col">Modelo</th>
                                                <th scope="col">Placa</th>
                                                <th colspan="2" scope="col">#</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php if (!empty($carros)): ?>
                                                <?php foreach ($carros as $carros): ?>
                                                    <tr>
                                                        <td><?= $carros->fabricante ?></td>
                                                        <td><?= $carros->modelo ?></td>
                                                        <td><?= $carros->placa ?></td>
                                                        <td><a href="javascript:void(0)"
                                                               onclick="MM_openBrWindow('frm_edita_veiculo.php?idveiculo=<?= $carros->idveiculo; ?>', '', 'scrollbars=no, width=900 height=550, left=0, top=150');"
                                                               class="btn btn-primary">Editar</a></td>
                                                        <td>
                                                            <form action="action_veiculo_cliente.php" method="post"
                                                                  class="text-white">
                                                                <input id="id" name="id" type="hidden"
                                                                       value="<?php echo $carros->idcliente; ?>"> <input
                                                                       id="idveiculo" name="idveiculo" type="hidden"
                                                                       value="<?php echo $carros->idveiculo; ?>">
                                                                <button class="btn btn-primary btn-lg btn-block btn-danger"
                                                                        type="submit" name="action">
                                                                    Excluir <input type="hidden" name="acao" value="excluir">

                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?> 
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </footer>
                            </div>

                            <a
                                href="frm_cad_veiculo_cliente.php?id=<?php echo $id_cliente; ?>"
                                class="btn-floating btn-large waves-effect waves-light"><i
                                    class="material-icons">add</i></a> <label class="text-white">Adicionar
                                Carros</label>
                        </div>
                        <hr />
                        <h5>Servi&ccedil;os</h5>
                        <div>

                            <a
                                href="frm_cad_contato_cliente.php?id=<?php echo $id_cliente; ?>"
                                class="btn-floating btn-large waves-effect waves-light"><i
                                    class="material-icons">add</i></a> <label class="text-white">Adicionar
                                Servi&ccedil;os</label>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Modal Structure -->

        <div id="modal1" class="modal modal-content red rounded bg-gradient-danger">

            <div class="modal-content red rounded bg-gradient-danger">
                <h5><?= $cliente->nome ?></h5>
            </div>

            <div class="modal-footer red rounded bg-gradient-danger">

                <?php if (!empty($verificaos)): ?>

                    <h5 class="text">"Atencao Existem ciclo de OS em Aberto para
                        este Cliente!!"</h5>
                    <h6>Para abrir uma nova OS Finalize a que se encontra-se pendente</h6>							

                    <?php if (!empty($verificaos)): ?>
                        <?php foreach ($verificaos as $verificaos): ?>
                            <form action="action_inicia_os.php" method="POST"
                                  class="red rounded bg-gradient-danger">

                                <div class="row">
                                    <div class="col s12 red rounded bg-gradient-danger">
                                        <input type="hidden" name="idcliente"
                                               value="<?= $verificaos->idcliente ?>" /> <input type="hidden"
                                               name="idos" value="<?= $verificaos->idos ?>" /> <input
                                               type="hidden" name="idveiculo"
                                               value="<?= $verificaos->idveiculo ?>" />
                                    </div>
                                </div>
                                <div class="row">
                                    <h5>
                                        <div class="col">Data OS: <?= $verificaos->dataos ?></div>
                                        <div class="col">Modelo: <?= $verificaos->modelo ?></div>
                                        <div class="col">Placa: <?= $verificaos->placa ?></div>
                                    </h5>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                        <input type="hidden" name="acao" value="incluir">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit"
                                                name="action">Abrir OS</button>
                                    </div>
                                </div>
                            </form>					  			

                        <?php endforeach; ?> 
                    <?php endif; ?>

                <?php else: ?>

                    <form action="action_inicia_os.php" method="POST"
                          id='form-contato' enctype='multipart/form-data'>
                        <input type="hidden" name="idcliente"
                               value="<?= $cliente->idcliente ?>" />
                               <?php if (empty($clienteos)) :else : ?>
                            <input type="hidden" name="idos"
                                   value="<?= $clienteos->idos ?>" />	
                               <?php endif; ?>	

                        <select name="idveiculo">
                            <option value="" disabled selected>Selecione Um Veiculo</option>
                            <?php if (!empty($veiculos)): ?>
                                <?php foreach ($veiculos as $veiculos): ?>						
                                    <option value="<?= $veiculos->idveiculo ?>"><?= $veiculos->modelo ?> - <?= $veiculos->placa ?></option>
                                <?php endforeach; ?> 
                            <?php endif; ?>
                        </select> <input type="hidden" name="acao" value="incluir">
                        <button class="btn btn-primary btn-lg btn-block" type="submit"
                                name="action">Abrir OS</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <script>
            var instance = M.Tabs.init(el, options);

            // Or with jQuery

            $(document).ready(function () {
                $('.tabs').tabs();
            });

        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var elems = document.querySelectorAll('.modal');
                var instances = M.Modal.init(elems, options);
            });

            // Or with jQuery

            $(document).ready(function () {
                $('.modal').modal();
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var elems = document.querySelectorAll('select');
                var instances = M.FormSelect.init(elems, options);
            });

            // Or with jQuery

            $(document).ready(function () {
                $('select').formSelect();
            });
        </script>
    </body>
</html>

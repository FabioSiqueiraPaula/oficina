<?php
include 'cabecalho.php';

$idcliente = (isset($_GET['id'])) ? $_GET['id'] : '';
$idos = (isset($_GET['idos'])) ? $_GET['idos'] : '';
$idveiculo = (isset($_GET['idveiculo'])) ? $_GET['idveiculo'] : '';

// Pega os dados do cliente
if (empty($clientes)) :
    // Executa uma consulta baseada no termo de pesquisa passado como parâmetro
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM cliente
                                            WHERE idcliente = :id';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':id', $idcliente);
    $stm->execute();
    $clientes = $stm->fetchAll(PDO::FETCH_OBJ);
endif;

// Pega os dados do Veiculo
if (empty($veiculo)) :
    // Executa uma consulta baseada no termo de pesquisa passado como parâmetro
    $conexao = conexao::getInstance();
    $sqlveiculo = 'SELECT * FROM veiculo
                                            WHERE idveiculo = :idveiculo';
    $stm = $conexao->prepare($sqlveiculo);
    $stm->bindValue(':idveiculo', $idveiculo);
    $stm->execute();
    $veiculo = $stm->fetchAll(PDO::FETCH_OBJ);
endif;

// Pega os os Itens da OS
if (empty($itens)) :
    $conexao = conexao::getInstance();
    $sqlitens = "SELECT * FROM os o
                                INNER JOIN os_itens oi
                                ON(oi.idos = o.idos)                                
                                WHERE o.idos = :idos AND o.idcliente = :idcliente AND o.idveiculo = :idveiculo AND o.status = 'ABERTO' ORDER BY oi.tipo";
    $stm = $conexao->prepare($sqlitens);
    $stm->bindValue(':idcliente', $idcliente);
    $stm->bindValue(':idos', $idos);
    $stm->bindValue(':idveiculo', $idveiculo);
    $stm->execute();
    $itens = $stm->fetchAll(PDO::FETCH_OBJ);
endif;

// Pega data de criacao da OS
$odb = new PDO('mysql:host=localhost;dbname=carselect', 'root', '');
$odb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dataos = $odb->query("SELECT dataos FROM os WHERE idos = $idos")->fetchColumn();

// Pega o Numero da OS
$odb = new PDO('mysql:host=localhost;dbname=carselect', 'root', '');
$odb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$os = $odb->query("SELECT idos FROM os WHERE idos = $idos")->fetchColumn();
?>

<div class="container">
    <footer class="page-footer red darken-4">
        <div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger">			
            <div class="z-depth-5">
                <table class="table table-dark border-1">
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $clientes): ?>
                            <tr>
                                <th colspan="3">
                                    <h6>OS Numero:&nbsp; <?php echo $os; ?></h6> <input type="hidden"
                                                                                        id="idos" name="idos" value="<?php echo $os; ?>" />
                                </th>
                                <th colspan="3">
                                    <h6>Data OS: <?php echo date('d/m/Y', strtotime($dataos)); ?></h6>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="6">
                                    <h5>Cliente:&nbsp; <?= $clientes->nome ?></h5>
                                </th>
                            </tr>					     
                        <?php endforeach; ?>                                        
                    <?php endif; ?>

                    <!--  Informa��es do Veiculo  --> 
                    <?php if (!empty($veiculo)): ?>
                        <?php foreach ($veiculo as $veiculo): ?> 
                            <tr>
                                <td>Fabricante: <b><?= $veiculo->fabricante ?></b></td>
                                <td>Modelo: <b><?= $veiculo->modelo ?></b></td>
                                <td>Motorizacao: <b><?= $veiculo->motorizacao ?></b></td>
                                <td>Ano: <b><?= $veiculo->ano ?></b></td>
                                <td>Placa: <b><?= $veiculo->placa ?></b></td>
                            </tr>
                        <?php endforeach; ?>                                        
                    <?php endif; ?>

                    <tr>
                        <th colspan="4">
                            <h5>Itens da OS</h5>
                        </th>
                        <th colspan="2"><a
                                class="waves-effect waves-light btn modal-trigger btn-floating btn-large"
                                href="#modal2"> <i class="material-icons">add</i></a> <label
                                class="text-white">Adicionar Itens</label></th>
                        <th colspan="6"></th>
                    </tr>
                    <tr style="background-color: #999; color: #F2F3FF;">
                        <th>Produto / Servico</th>
                        <th>Descricao</th>
                        <th>Valor</th>
                        <th>Valor Acrecimo</th>
                        <th>Valor Total</th>
                        <th>Ação</th>
                    </tr>
                    <?php if (!empty(($itens))): ?>
                        <?php foreach ($itens as $itens): ?>  
                            <?php
                            $odbtotal = new PDO('mysql:host=localhost;dbname=carselect', 'root', '');
                            $odbtotal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $totalpecas = $odbtotal->prepare("SELECT SUM(valor) FROM os_itens WHERE tipo = 'peca' AND idos = $itens->idos");
                            $totalpecas->execute();

                            $totalservicos = $odbtotal->prepare("SELECT SUM(valor) FROM os_itens WHERE tipo = 'servico' AND idos = $itens->idos");
                            $totalservicos->execute();

                            $totalacrecimo = $odbtotal->prepare("SELECT SUM(valoracrecimo) FROM os_itens WHERE tipo = 'peca' AND idos = $itens->idos");
                            $totalacrecimo->execute();

                            $totalacrecimopeca = $odbtotal->prepare("SELECT SUM(total) FROM os_itens WHERE tipo = 'peca' AND idos = $itens->idos");
                            $totalacrecimopeca->execute();


                            $totalos = $odbtotal->prepare("SELECT SUM(total) FROM os_itens WHERE idos = $itens->idos");
                            $totalos->execute();
                            ?>                                     

                            <tr>
                                <?php if ($itens->tipo == "Servico"): ?>
                                    <th style="font-style: inherit; color: lime;" class="z-depth-5"><?= $itens->tipo ?></th>
                                    <th style="font-style: inherit; color: lime;" class="z-depth-5"> <?= $itens->descricao ?></th>
                                    <th style="font-style: inherit; color: lime;" class="z-depth-5">R$ <?= number_format($itens->valor, 2, ',', '.'); ?></th>
                                    <th style="font-style: inherit; color: lime;" class="z-depth-5">R$ <?= number_format($itens->valoracrecimo, 2, ',', '.'); ?></th>
                                    <th style="font-style: inherit; color: lime;" class="z-depth-5">R$ <?= number_format($itens->total, 2, ',', '.'); ?></th>
                                <?php else : ?>
                                    <th style="font-style: inherit; color: yellow;" class="z-depth-5"><?= $itens->tipo ?></th>
                                    <th style="font-style: inherit; color: yellow;" class="z-depth-5"><?= $itens->descricao ?></th>
                                    <th style="font-style: inherit; color: yellow;" class="z-depth-5">R$ <?= number_format($itens->valor, 2, ',', '.'); ?></th>
                                    <th style="font-style: inherit; color: yellow;" class="z-depth-5">R$ <?= number_format($itens->valoracrecimo, 2, ',', '.'); ?></th>
                                    <th style="font-style: inherit; color: yellow;" class="z-depth-5">R$ <?= number_format($itens->total, 2, ',', '.'); ?></th>
                                <?php endif; ?>
                                <th>
                                    <form action="action_inicia_os.php" method="POST" id='form-contato' enctype='multipart/form-data'>				

                                        <input type="hidden" id="idos_itens" name="idos_itens" value="<?= $itens->idos_itens ?>" />								
                                        <input type="hidden" id="idos" name="idos" value="<?php echo $os; ?>" />								
                                        <input type="hidden" id="id" name="id" value="<?php echo $idcliente; ?>" />								
                                        <input type="hidden" id="idveiculo" name="idveiculo" value="<?php echo $idveiculo; ?>" />

                                        <input type="hidden" name="acao" value="excluir">
                                        <button type="submit"
                                                class="btn btn-primary btn-lg btn-block btn-danger" id="botao">Excluir</button>
                                    </form>
                                </th>
                            </tr>                                  
                        <?php endforeach; ?>                            
                    </table>
                </div>
                <div class="z-depth-5">
                    <form action="action_inicia_os.php" method="POST" id='form-contato'
                          enctype='multipart/form-data'>

                        <table class="table table-dark border-1 z-depth-5">
                            <tr style="color: #F2F3FF;">
                                <th style="font-style: inherit; color: yellow;" class="z-depth-5">Total Pecas</th>
                                <th style="font-style: inherit; color: yellow;" class="z-depth-5">
                                    R$ 
                                    <?php
                                    $resultotalpecas = $totalpecas->fetchColumn();
                                    echo number_format($resultotalpecas, 2, ',', '.');
                                    
                                    $resultotalacrecimopeca = $totalacrecimopeca->fetchColumn();                                    
                                    ?>
                                    <input type="hidden"
                                           value="<?php echo number_format($resultotalacrecimopeca, 2, ',', '.'); ?>"
                                           name="totalpecas">
                                </th>
                                <th style="background-color: black;" class="z-depth-5">Total Acrecimo</th>
                                <th style="background-color: black;" class="z-depth-5">
                                    R$ 
                                    <?php
                                    $resultotalacrecimo = $totalacrecimo->fetchColumn();
                                    echo number_format($resultotalacrecimo, 2, ',', '.');
                                    ?>
                                    <input type="hidden"
                                           value="<?php echo number_format($resultotalacrecimo, 2, ',', '.'); ?>"
                                           name="totalacrecimo">
                                </th>
                                <th style="font-style: inherit; color: lime;" class="z-depth-5">Total Servicos</th>
                                <th style="font-style: inherit; color: lime;;" class="z-depth-5">
                                    R$ 
                                    <?php
                                    $resultotalservicos = $totalservicos->fetchColumn();
                                    echo number_format($resultotalservicos, 2, ',', '.');
                                    ?>
                                    <input type="hidden"
                                           value="<?php echo number_format($resultotalservicos, 2, ',', '.'); ?>"
                                           name="totalservicos">
                                </th>
                                <th style="background-color: green;" class="z-depth-5">Total OS</th>
                                <th style="background-color: green;" class="z-depth-5">
                                    R$ 
                                    <?php
                                    $resultotalos = $totalos->fetchColumn();
                                    echo number_format($resultotalos, 2, ',', '.');
                                    ?>
                                    <input type="hidden"
                                           value="<?php echo number_format($resultotalos, 2, ',', '.'); ?>"
                                           id="totalos" name="totalos">

                                    <input type="hidden"
                                           value="FECHADO"
                                           name="status">

                                    <input type="hidden"
                                           id="idos" name="idos" value="<?php echo $os; ?>" />
                                </th>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <th colspan="8"><input type="hidden" name="acao" value="encerrar">
                                <button type="submit"
                                        class="btn btn-primary btn-lg btn-block btn-danger" id="botao">Encerrar
                                    OS</button></th>
                        </tr>
                    </table>
                </form>
            </div>

            <!-- Modal Structure -->
            <div id="modal2" class="modal modal-fixed-footer red rounded bg-gradient-danger">
                <form action="action_inicia_os.php" method="POST">	
                    <div class="modal-content red rounded bg-gradient-danger">

                        <h3>Inclusao de Itens na OS</h3>

                        <div class="row">
                            <div class="input-field">
                                <input type="text" name="idos" value="<?= $idos ?>" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s2">
                                Tipo Servico/Peca
                                <select name="tipo" id="tipo" onchange="desabilitaInput()">
                                    <option value="" disabled selected>Selecione Tipo</option>
                                    <option value="Peca">Peca</option>
                                    <option value="Servico">Servico</option>
                                </select> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s10">
                                Desc Servico/Peca											
                                <input type="text" name="descricao"> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s4">
                                Fornecedor									
                                <select name="fornecedor" id="fornecedor">
                                    <option value="" disabled selected>Fornecido Por</option>
                                    <option value="Cliente">Cliente</option>
                                    <option value="Oficina">Oficina</option>
                                </select>										
                            </div>
                            <div class="input-field col s4">
                                V Compra/Serv
                                <input type="text" name="valor" id="valor" placeholder="R$">
                            </div>
                            <div class="input-field col s4">
                                Acrecimo (%)
                                <input type="text" name="porcacrecimo" id="porcacrecimo" placeholder="%">
                            </div>
                            <div class="input-field col s4">
                                V do Acrecimo
                                <input type="text" name="valoracrecimo" id="valoracrecimo" placeholder="R$" onblur="soma()" readonly>
                            </div>
                            <div class="input-field col s4">
                                Valor Total
                                <input type="text" name="total" id="total" readonly>
                            </div>
                        </div>								
                    </div>							

                    <div class="modal-footer red rounded bg-gradient-danger">
                        <input type="hidden" name="acao" value="inserir">
                        <button class="btn btn-primary btn-lg btn-block" id="botao" type="submit" name="action">Incluir Item</button>
                    </div>
                </form>
            </div>


        </div>
    </footer>
</div>


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
    /*
     function desabilitaInput() {
     var tipo = document.getElementById("tipo");    
     
     var opcaoSelecionada = tipo.options[tipo.selectedIndex].value;   
     
     if (opcaoSelecionada != 'Servico') {
     document.getElementById("porcacrecimo").disabled = true; 
     document.getElementById("fornecedor").value = "Oficina";                  
     }
     else {
     document.getElementById("porcacrecimo").disabled = false;
     document.getElementById("fornecedor").disabled = false;        
     }   
     
     }	
     */
</script>

<<script type="text/javascript">

    function id(valor_campo)
    {
        return document.getElementById(valor_campo);
    }

    function getValor(valor_campo)
    {
        var valor = document.getElementById(valor_campo).value.replace(',', '.');
        return parseFloat(valor) * 100;
    }

    function soma()
    {
        var total = getValor('valor') + getValor('valoracrecimo');
        id('total').value = total / 100;
    }
</script>


<script>
    document.getElementById('porcacrecimo').onkeyup = function () {

        var valor = parseFloat(document.getElementById('valor').value);

        document.getElementById('valoracrecimo').value = valor * (parseFloat(this.value) / 100);

    }
</script>

<!-- Formata Moeda -->
<script type="text/javascript">
    function moeda(a, e, r, t) {
        let n = ""
                , h = j = 0
                , u = tamanho2 = 0
                , l = ajd2 = ""
                , o = window.Event ? t.which : t.keyCode;
        a.value = a.value.replace('R$ ', '');
        if (n = String.fromCharCode(o),
                -1 == "0123456789".indexOf(n))
            return !1;
        for (u = a.value.replace('R$ ', '').length,
                h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
            ;
        for (l = ""; h < u; h++)
            -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
        if (l += n,
                0 == (u = l.length) && (a.value = ""),
                1 == u && (a.value = "R$ 0" + r + "0" + l),
                2 == u && (a.value = "R$ 0" + r + l),
                u > 2) {
            for (ajd2 = "",
                    j = 0,
                    h = u - 3; h >= 0; h--)
                3 == j && (ajd2 += e,
                        j = 0),
                        ajd2 += l.charAt(h),
                        j++;
            for (a.value = "R$ ",
                    tamanho2 = ajd2.length,
                    h = tamanho2 - 1; h >= 0; h--)
                a.value += ajd2.charAt(h);
            a.value += r + l.substr(u - 2, u)
        }
        return !1
    }
</script>

</body>
</html>

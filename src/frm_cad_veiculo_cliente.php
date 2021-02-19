<?php
require 'cabecalho.php';

// Recebe o id do cliente do cliente via GET
$id_cliente = (isset($_GET['id'])) ? $_GET['id'] : '';

// Busca Dados Aluno
if (!empty($id_cliente) && is_numeric($id_cliente)) :
    // Captura os dados do Cliente
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM cliente WHERE idcliente = :id';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':id', $id_cliente);
    $stm->execute();
    $cliente = $stm->fetch(PDO::FETCH_OBJ);
endif;
?>


<script type="text/javascript"
src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<div class="container">
    <footer class="page-footer red darken-4">
        <div class="shadow-lg p-3 mb-5 bg-red rounded">
            <h4 class="text-white">Cadastro de Cliente [ Veiculos ]</h4>
        </div>

        <form action="action_veiculo_cliente.php" method="post"
              class="text-white">

            <div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger">

                <div class="row">
                    <input id="id" name="id" type="hidden"
                           value="<?php echo $cliente->idcliente; ?>">
                    <div class="shadow-lg p-3 mb-5 bg-red rounded">
                        <h5 class="text-white"> <?php echo $cliente->nome; ?></h5>
                    </div>
                </div>


                <div class="row">
                    <div class="input-field col s5">
                        <div class="input-group input-group-mb">
                            Fabricante <input type="text" name="fabricante" id="fabricante"
                                              class="form-control text-white"
                                              aria-label="Sizing example input"
                                              aria-describedby="inputGroup-sizing-mb" maxlength="20">
                        </div>
                    </div>
                    <div class="input-field col s5">
                        <div class="input-group input-group-mb">
                            Modelo <input type="text" name="modelo" id="modelo"
                                          class="form-control text-white"
                                          aria-label="Sizing example input"
                                          aria-describedby="inputGroup-sizing-mb" maxlength="20">
                        </div>
                    </div>
                    <div class="input-field col s2">
                        <div class="input-group input-group-mb">
                            Ano <input type="text" name="ano" id="ano"
                                       class="form-control text-white"
                                       aria-label="Sizing example input"
                                       aria-describedby="inputGroup-sizing-mb" maxlength="9">
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="input-field col s2">
                        <div class="input-group input-group-mb">
                            Cor <input type="text" name="cor" id="cor"
                                       class="form-control text-white"
                                       aria-label="Sizing example input"
                                       aria-describedby="inputGroup-sizing-mb" maxlength="9">
                        </div>
                    </div>
                    <div class="input-field col s2">
                        <div class="input-group input-group-mb">
                            Motorização <input type="text" name="motorizacao"
                                               id="motorizacao" class="form-control text-white"
                                               aria-label="Sizing example input"
                                               aria-describedby="inputGroup-sizing-mb" maxlength="9">
                        </div>
                    </div>
                    <div class="input-field col s2">
                        <div class="input-group input-group-mb">
                            Placa <input type="text" name="placa" id="placa"
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
                            <input type="hidden" name="acao" value="incluir"> Salvar
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </footer>
</div>

<script type="text/javascript">
    $("#cep").focusout(function () {
        //In�cio do Comando AJAX
        $.ajax({
            //O campo URL diz o caminho de onde vir� os dados
            //� importante concatenar o valor digitado no CEP
            url: 'https://viacep.com.br/ws/' + $(this).val() + '/json/unicode/',
            //Aqui voc� deve preencher o tipo de dados que ser� lido,
            //no caso, estamos lendo JSON.
            dataType: 'json',
            //SUCESS � referente a fun��o que ser� executada caso
            //ele consiga ler a fonte de dados com sucesso.
            //O par�metro dentro da fun��o se refere ao nome da vari�vel
            //que voc� vai dar para ler esse objeto.
            success: function (resposta) {
                //Agora basta definir os valores que voc� deseja preencher
                //automaticamente nos campos acima.
                $("#logradouro").val(resposta.logradouro);
                $("#bairro").val(resposta.bairro);
                $("#cidade").val(resposta.localidade);
                $("#uf").val(resposta.uf);
                //Vamos incluir para que o N�mero seja focado automaticamente
                //melhorando a experi�ncia do usu�rio
                $("#numero").focus();
            }
        });
    });
</script>


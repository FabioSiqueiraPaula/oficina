<?php
require 'cabecalho.php';

// Recebe o id do cliente do cliente via GET
$id_cliente = (isset($_GET['id'])) ? $_GET['id'] : '';

// Busca Dados Aluno
if (!empty($id_cliente) && is_numeric($id_cliente)) :
    // Captura os dados do Aluno
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
            <h4 class="text-white">Cadastro de Cliente [ Endere&ccedil;o ]</h4>
        </div>

        <form action="action_endereco_cliente.php" method="post" class="text-white">

            <div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger">

                <div class="row">
                    <input id="id" name="id" type="hidden"
                           value="<?php echo $cliente->idcliente; ?>">
                    <div class="shadow-lg p-3 mb-5 bg-red rounded">
                        <h5 class="text-white"> <?php echo $cliente->nome; ?></h5>
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <div class="input-group input-group-mb">
                             CEP
                             <input type="text" name="cep" id="cep" class="form-control text-white"
                                    aria-label="Sizing example input" aria-describedby="inputGroup-sizing-mb"
                                    placeholder="Ex.: 00000-000" onKeyPress="MascaraCep(formulario.cep);" maxlength="10">
                        </div>
                    </div>
                    <div class="col"></div>
                </div>
             
                <div class="row">
                    <div class="col">
                        <div class="input-group input-group-mb">
                            Logradouro  
                            <input type="text" name="logradouro" id="logradouro" class="form-control text-white"
                                   aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>               
                    <div class="col">
                        <div class="input-group input-group-lg">
                            Numero  
                            <input id="numero" name="numero" type="text" class="form-control text-white"
                                   aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-lg">
                            Complemento
                            <input id="complemento" name="complemento" type="text" class="form-control text-white" 
                                   aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="input-group input-group-lg">
                            Bairro
                            <input id="bairro" name="bairro" type="text" class="form-control text-white"
                                   aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-lg">
                            Cidade 
                            <input id="cidade" name="cidade" type="text" class="form-control text-white"
                                   aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-lg">
                            UF  
                            <input id="uf" name="uf" type="text" class="form-control text-white"
                                   aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                </div>

               <div class="row">
                    <div class="progress">
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" style="width: 66%">
                            <span class="sr-only">66% Complete (danger)</span>
                        </div>
                    </div>
                </div>   
          
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


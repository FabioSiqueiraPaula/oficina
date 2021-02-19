<?php
require 'cabecalho.php';
?>


<script type="text/javascript"
src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<div class="container">
    <footer class="page-footer red darken-4">
        <div class="shadow-lg p-3 mb-5 bg-red rounded">
            <h4 class="text-white">Cadastro da Empresa</h4>
        </div>

        <form action="action_cad_empresa.php" method="post" class="text-white">

            <div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger"> 
                <div class="row">
                    <div class="col">
                        <a href="#" class="thumbnail">
                                        <img src="./img/padrao.jpg" height="190" width="150" id="foto-produto">
                                    </a>
                                    <label for="nome">Selecionar Foto</label>
                        <div class="input-group input-group-mb">
                            Logo <input type="file"
                                              name="logo" class="form-control text-white"
                                              aria-label="Sizing example input"
                                              aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group input-group-mb">
                         Empresa <input type="text"
                                              name="nomeempresa" class="form-control text-white"
                                              aria-label="Sizing example input"
                                              aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="input-group input-group-mb">
                         CNPJ <input type="text"
                                              name="cnpj" class="form-control text-white"
                                              aria-label="Sizing example input"
                                              aria-describedby="inputGroup-sizing-lg">
                        </div>
                        <div class="input-group input-group-mb">
                         IE <input type="text"
                                              name="ie" class="form-control text-white"
                                              aria-label="Sizing example input"
                                              aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="input-group input-group-mb">
                            CEP <input type="text"
                                       name="cep" id="cep" class="form-control text-white"
                                       aria-label="Sizing example input"
                                       aria-describedby="inputGroup-sizing-mb"
                                       placeholder="Ex.: 00000-000"
                                       onKeyPress="MascaraCep(formulario.cep);" maxlength="10">
                        </div>
                    </div>
                    <div class="col"></div>
                </div>

                <hr />

                <div class="row">
                    <div class="col">
                        <div class="input-group input-group-mb">
                            Logradouro <input type="text"
                                              name="logradouro" id="logradouro" class="form-control text-white"
                                              aria-label="Sizing example input"
                                              aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <div class="col">
                        <div class="input-group input-group-lg">
                            Numero <input id="numero"
                                                                                  name="numero" type="text" class="form-control text-white"
                                                                                  aria-label="Sizing example input"
                                                                                  aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-lg">
                            Complemento <input
                                id="complemento" name="complemento" type="text"
                                class="form-control text-white" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <div class="col">
                        <div class="input-group input-group-lg">
                            Bairro <input id="bairro"
                                                                                  name="bairro" type="text" class="form-control text-white"
                                                                                  aria-label="Sizing example input"
                                                                                  aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-lg">
                            Cidade<input id="cidade"
                                                                                  name="cidade" type="text" class="form-control text-white"
                                                                                  aria-label="Sizing example input"
                                                                                  aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-lg">
                           UF <input id="uf"
                                                                              name="uf" type="text" class="form-control text-white"
                                                                              aria-label="Sizing example input"
                                                                              aria-describedby="inputGroup-sizing-lg">
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


<?php
include 'cabecalho.php';
?>
<html>
    <body>
        <div class="container">
            <footer class="page-footer red darken-4">
                <form action="action_dados_cliente.php" method="post" class="text-white">
                    <div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger">
                        <div class="row">
                            <input id="dtcadatro" name="dtcadastro" type="hidden"
                                   value="<?php
                                   $hoje = date('d/m/Y');
                                   echo $hoje;
                                   ?>"> <input
                                   id="ativo" name="ativo" type="hidden" value="1"> <label
                                   for="inputAddress">Nome</label> <input type="text" name="nome"
                                   class="form-control text-white" placeholder="Digite o Nome">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="inputCity">Nascimento</label> <input type="text"
                                                                                 name="dtnascimento" class="form-control text-white"
                                                                                 placeholder="Digite a Data de Nascimento">
                            </div>
                            <div class="col-md-4">
                                <label>Sexo</label> <select name="sexo">
                                    <option selected>Escolher...</option>
                                    <option value="Feminino">Feminino</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>CPF</label> <input type="text" class="form-control text-white"
                                                          name="cpf">
                            </div>
                        </div>

                        <div class="row">
                            <div class="progress">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%">
                                    <span class="sr-only">33% Complete (danger)</span>
                                </div>
                            </div>
                        </div>   

                        <div class="row">
                            <div class="col 12">
                                <button type="submit" class="btn btn-primary btn-lg btn-block btn-danger">
                                    <input type="hidden" name="acao" value="incluir">Proximo
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </footer></div


    </body>
</html>

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
<?php  require 'cabecalho.php'; ?>
        <div id="push"></div>          
        <div class='container box-mensagem-crud'>
            <?php
            // Atribui uma conexão PDO
            $conexao = conexao::getInstance();

            // Recebe os dados enviados pela submissão
            $acao 		 = (isset($_POST['acao'])) ? $_POST['acao'] : '';
            $idveiculo   = (isset($_POST['idveiculo'])) ? $_POST['idveiculo'] : '';
            $fabricante  = (isset($_POST['fabricante'])) ? $_POST['fabricante'] : '';
            $modelo 	 = (isset($_POST['modelo'])) ? $_POST['modelo'] : '';
            $ano 		 = (isset($_POST['ano'])) ? $_POST['ano'] : ''; 
            $cor 		 = (isset($_POST['cor'])) ? $_POST['cor'] : ''; 
            $motorizacao = (isset($_POST['motorizacao'])) ? $_POST['motorizacao'] : '';
            $placa 		 = (isset($_POST['placa'])) ? $_POST['placa'] : ''; 
            $idcliente 	 = (isset($_POST['id'])) ? $_POST['id'] : '';

           
            
            // Valida os dados recebidos
            $mensagem = '';
            if ($acao == 'editar' && $idveiculo == ''):
                $mensagem .= '<li>ID do registros desconhecido.</li>';
            endif;

            // Se for ação diferente de excluir valida os dados obrigatórios
            if ($acao != 'excluir'):
                if ($fabricante == '' || strlen($fabricante) < 3):
                    $mensagem .= '<li>Favor preencher o Fabricante.</li>';
                endif;
                
                if ($modelo == '' || strlen($modelo) < 3):
                $mensagem .= '<li>Favor preencher o modelo.</li>';
                endif;
                
                if ($ano == '' || strlen($ano) < 3):
                $mensagem .= '<li>Favor preencher o Ano.</li>';
                endif;
                
                if ($motorizacao == '' || strlen($motorizacao) < 3):
                $mensagem .= '<li>Favor preencher a Motoriza��o.</li>';
                endif;
                
                if ($mensagem != ''):
                    $mensagem = '<ul>' . $mensagem . '</ul>';
                    echo "<div class='alert alert-danger' role='alert'>" . $mensagem . "</div> ";
                    exit;
                endif;
            endif;
            
            // Verifica se foi solicitada a inclusão de dados
            if ($acao == 'incluir'):
               

            $fabricante  = (isset($_POST['fabricante'])) ? $_POST['fabricante'] : '';
            $modelo 	= (isset($_POST['modelo'])) ? $_POST['modelo'] : '';
            $ano 		= (isset($_POST['ano'])) ? $_POST['ano'] : '';
            $cor 		 = (isset($_POST['cor'])) ? $_POST['cor'] : '';
            $motorizacao = (isset($_POST['motorizacao'])) ? $_POST['motorizacao'] : '';
            $placa 		 = (isset($_POST['placa'])) ? $_POST['placa'] : ''; 
            $idcliente 	= (isset($_POST['id'])) ? $_POST['id'] : '';
                
                $odb = new PDO('mysql:host=localhost;dbname=carselect', 'root', '');
                $odb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $searcha = $odb->query("SELECT * FROM veiculo WHERE idcliente = '$idcliente' AND placa = '$placa'")->fetchColumn();
                

                if ($searcha == '') : // não for maior que zero
                    $sql = 'INSERT INTO veiculo (fabricante, modelo, ano, cor, motorizacao, placa, idcliente)
							   VALUES(:fabricante, :modelo, :ano, :cor, :motorizacao, :placa, :idcliente)';

                    $stm = $conexao->prepare($sql);
                    $stm->bindValue(':fabricante', $fabricante);
                    $stm->bindValue(':modelo', $modelo);
                    $stm->bindValue(':cor', $cor);
                    $stm->bindValue(':ano', $ano);
                    $stm->bindValue(':motorizacao', $motorizacao);
                    $stm->bindValue(':cor', $cor);
                    $stm->bindValue(':placa', $placa);
                    $stm->bindValue(':idcliente', $idcliente);
                    $retorno = $stm->execute();

                    if ($retorno):
                        echo "<div class='alert alert-success' role='alert'>Registro inserido com sucesso, aguarde você está sendo redirecionado ...</div> ";
                    else:
                        echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div> ";
                    endif;
                else:
                    echo "<div class='alert alert-danger' role='alert'>Produto já cadastrado no Sistema!</div> ";                
              
                endif;
                echo "<meta http-equiv=refresh content='3;URL=frm_cliente.php?id=$idcliente'>";
            endif;


            // Verifica se foi solicitada a edição de dados
            if ($acao == 'editar'):               

                $sql = 'UPDATE veiculo SET fabricante=:fabricante, modelo=:modelo, cor=:cor, ano=:ano, motorizacao=:motorizacao, placa=:placa';
                $sql = 'WHERE idveiculo=:idveiculo';

                $stm = $conexao->prepare($sql);                
                $stm->bindValue(':fabricante', $fabricante);
                $stm->bindValue(':modelo', $modelo);
                $stm->bindValue(':cor', $cor);
                $stm->bindValue(':ano', $ano);
                $stm->bindValue(':motorizacao', $motorizacao);                
                $stm->bindValue(':placa', $placa);               
                $retorno = $stm->execute();
                

                if ($retorno):
                    echo "<div class='alert alert-success' role='alert'>Registro editado com sucesso, aguarde você está sendo redirecionado ...</div> ";
                else:
                    echo "<div class='alert alert-danger' role='alert'>Erro ao editar registro!</div> ";
                endif;

                echo "<meta http-equiv=refresh content='3;URL=frm_cliente.php?id=$idcliente'>";
            endif;


            // Verifica se foi solicitada a exclusão dos dados
            if ($acao == 'excluir'):                

                // Exclui o registro do banco de dados
                $sql = 'DELETE FROM veiculo WHERE idveiculo = :idveiculo';
                $stm = $conexao->prepare($sql);
                $stm->bindValue(':idveiculo', $idveiculo);
                $retorno = $stm->execute();

                if ($retorno):
                    echo "<div class='alert alert-success' role='alert'>Registro excluído com sucesso, aguarde você está sendo redirecionado ...</div> ";
                else:
                    echo "<div class='alert alert-danger' role='alert'>Erro ao excluir registro!</div> ";
                endif;

                echo "<meta http-equiv=refresh content='3;URL=frm_cliente.php?id=$idcliente'>";
            endif;
            ?>
        </div>   
    </body>
</html>
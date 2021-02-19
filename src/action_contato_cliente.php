<?php  require 'cabecalho.php'; ?>
        <div id="push"></div>          
        <div class='container box-mensagem-crud'>
            <?php
            // Atribui uma conexão PDO
            $conexao = conexao::getInstance();

            // Recebe os dados enviados pela submissão
            $acao 	= (isset($_POST['acao'])) ? $_POST['acao'] : '';
            $idcontato  = (isset($_POST['idcontato'])) ? $_POST['idcontato'] : '';
            $telefone1  = (isset($_POST['telefone1'])) ? $_POST['telefone1'] : '';
            $telefone2 	= (isset($_POST['telefone2'])) ? $_POST['telefone2'] : '';
            $email 	= (isset($_POST['email'])) ? $_POST['email'] : '';            
            $idcliente 	= (isset($_POST['id'])) ? $_POST['id'] : '';

           
            
            // Valida os dados recebidos
            $mensagem = '';
            if ($acao == 'editar' && $idcontato == ''):
                $mensagem .= '<li>ID do registros desconhecido.</li>';
            endif;

            // Se for ação diferente de excluir valida os dados obrigatórios
            if ($acao != 'excluir'):
                if ($telefone1 == '' || strlen($telefone1) < 3):
                    $mensagem .= '<li>Favor preencher Telefone 1.</li>';
                endif;
                
                if ($mensagem != ''):
                    $mensagem = '<ul>' . $mensagem . '</ul>';
                    echo "<div class='alert alert-danger' role='alert'>" . $mensagem . "</div> ";
                    exit;
                endif;
            endif;
            
            // Verifica se foi solicitada a inclusão de dados
            if ($acao == 'incluir'):
               

            $telefone1  = (isset($_POST['telefone1'])) ? $_POST['telefone1'] : '';
            $telefone2 	= (isset($_POST['telefone2'])) ? $_POST['telefone2'] : '';
            $email 	= (isset($_POST['email'])) ? $_POST['email'] : '';
            $idcliente 	= (isset($_POST['id'])) ? $_POST['id'] : '';
                
                $odb = new PDO('mysql:host=localhost;dbname=carselect', 'root', '');
                $odb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $searcha = $odb->query("SELECT * FROM contato WHERE idcliente = '$idcliente' AND telefone1 = '$telefone1'")->fetchColumn();
                

                if ($searcha == '') : // não for maior que zero
                    $sql = 'INSERT INTO contato (telefone1, telefone2, email, idcliente)
							   VALUES(:telefone1, :telefone2, :email, :idcliente)';

                    $stm = $conexao->prepare($sql);
                    $stm->bindValue(':telefone1', $telefone1);
                    $stm->bindValue(':telefone2', $telefone2);
                    $stm->bindValue(':email', $email);                    
                    $stm->bindValue(':idcliente', $idcliente); 
                    $retorno = $stm->execute();

                    if ($retorno):
                        echo "<div class='alert alert-success' role='alert'>Registro inserido com sucesso, aguarde você está sendo redirecionado ...</div> ";
                    else:
                        echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div> ";
                    endif;
                else:
                    echo "<div class='alert alert-danger' role='alert'>Telefone já cadastrado no Sistema!</div> ";                
              
                endif;
                echo "<meta http-equiv=refresh content='3;URL=frm_cliente.php?id=$idcliente'>";
            endif;


            // Verifica se foi solicitada a edição de dados
            if ($acao == 'editar'):               

                $sql = 'UPDATE contato SET telefone1=:telefone1, telefone2=:telefone2, email=:email';
                $sql .= 'WHERE idcontato = :idcontato';

                $stm = $conexao->prepare($sql);
                $stm->bindValue(':telefone1', $telefone1);
                $stm->bindValue(':telefone2', $telefone2);
                $stm->bindValue(':email', $email);
                $stm->bindValue(':idcliente', $idcliente);
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
                $sql = 'DELETE FROM contato WHERE idcontato = :idcontato';
                $stm = $conexao->prepare($sql);
                $stm->bindValue(':idcontato', $idcontato);
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
<?php  require 'cabecalho.php'; ?>
        <div id="push"></div>          
        <div class='container box-mensagem-crud'>
            <?php
            // Atribui uma conexão PDO
            $conexao = conexao::getInstance();

            // Recebe os dados enviados pela submissão
            $acao 			= (isset($_POST['acao'])) ? $_POST['acao'] : '';
            $endid 			= (isset($_POST['endid'])) ? $_POST['endid'] : '';            
            $cep 			= (isset($_POST['cep'])) ? $_POST['cep'] : '';
            $logradouro 	= (isset($_POST['logradouro'])) ? $_POST['logradouro'] : '';
            $numero 		= (isset($_POST['numero'])) ? $_POST['numero'] : '';
            $complemento 	= (isset($_POST['complemento'])) ? $_POST['complemento'] : '';
            $bairro			= (isset($_POST['bairro'])) ? $_POST['bairro'] : '';
            $cidade 		= (isset($_POST['cidade'])) ? $_POST['cidade'] : '';
            $uf 			= (isset($_POST['uf'])) ? $_POST['uf'] : '';
            $idcliente 	    = (isset($_POST['id'])) ? $_POST['id'] : '';

           
            
            // Valida os dados recebidos
            $mensagem = '';
            if ($acao == 'editar' && $endid == ''):
                $mensagem .= '<li>ID do registros desconhecido.</li>';
            endif;

            // Se for ação diferente de excluir valida os dados obrigatórios
            if ($acao != 'excluir'):
                if ($cep == '' || strlen($cep) < 3):
                    $mensagem .= '<li>Favor preencher CEP.</li>';
                endif;

                if ($logradouro == ''):
                    $mensagem .= '<li>Favor preencher o logradouro.</li>';
                endif;

                if ($numero == ''):
                    $mensagem .= '<li>Favor preencher o Tipodsdsdssd.</li>';
                endif;

                if ($complemento == ''):
                    $mensagem .= '<li>Favor preencher o Complemento.</li>';
                endif;

                if ($bairro == ''):
                    $mensagem .= '<li>Favor preencher o Bairro.</li>';
                endif;

                if ($cidade == ''):
                    $mensagem .= '<li>Favor preencher o Preco do produto.</li>';
                endif;

                if ($uf == ''):
                    $mensagem .= '<li>Favor preencher o Status.</li>';
                endif;

                if ($mensagem != ''):
                    $mensagem = '<ul>' . $mensagem . '</ul>';
                    echo "<div class='alert alert-danger' role='alert'>" . $mensagem . "</div> ";
                    exit;
                endif;
            endif;
            
            // Verifica se foi solicitada a inclusão de dados
            if ($acao == 'incluir'):
               

                $logradouro 	= $_POST['logradouro'];
                $numero 		= $_POST['numero'];
                $cep 			= $_POST['cep'];
                $complemento 	= $_POST['complemento'];
                $idcliente 	    = $_POST['id'];
                
                $odb = new PDO('mysql:host=localhost;dbname=carselect', 'root', '');
                $odb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $searcha = $odb->query("SELECT * FROM endereco WHERE idcliente = '$idcliente' AND logradouro = '$logradouro' AND numero = '$numero' AND cep = '$cep' AND complemento = '$complemento'")->fetchColumn();
                

                if ($searcha == '') : // não for maior que zero
                    $sql = 'INSERT INTO endereco (cep, logradouro, numero, complemento, bairro, cidade, uf, idcliente)
							   VALUES(:cep, :logradouro, :numero, :complemento, :bairro, :cidade, :uf, :idcliente)';

                    $stm = $conexao->prepare($sql);
                    $stm->bindValue(':cep', $cep);
                    $stm->bindValue(':logradouro', $logradouro);
                    $stm->bindValue(':numero', $numero);
                    $stm->bindValue(':complemento', $complemento);
                    $stm->bindValue(':bairro', $bairro);
                    $stm->bindValue(':cidade', $cidade);
                    $stm->bindValue(':uf', $uf);
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
                echo "<meta http-equiv=refresh content='3;URL=frm_cad_contato_cliente.php?id=$idcliente'>";
            endif;


            // Verifica se foi solicitada a edição de dados
            if ($acao == 'editar'):               

                $sql = 'UPDATE endereco SET cep=:cep, logradouro=:logradouro, numero=:numero, complemento=:complemento, bairro=:bairro, cidade=:cidade, uf=:uf';
                $sql .= 'WHERE enderecoid = :endid';

                $stm = $conexao->prepare($sql);
                $stm->bindValue(':cep', $cep);
                $stm->bindValue(':logradouro', $logradouro);
                $stm->bindValue(':numero', $numero);
                $stm->bindValue(':complemento', $complemento);
                $stm->bindValue(':bairro', $bairro);
                $stm->bindValue(':cidade', $cidade);
                $stm->bindValue(':uf', $uf);
                $retorno = $stm->execute();
                

                if ($retorno):
                    echo "<div class='alert alert-success' role='alert'>Registro editado com sucesso, aguarde você está sendo redirecionado ...</div> ";
                else:
                    echo "<div class='alert alert-danger' role='alert'>Erro ao editar registro!</div> ";
                endif;

                echo "<meta http-equiv=refresh content='3;URL=lista_produto.php'>";
            endif;


            // Verifica se foi solicitada a exclusão dos dados
            if ($acao == 'excluir'):                

                // Exclui o registro do banco de dados
                $sql = 'DELETE FROM endereco WHERE id = :id';
                $stm = $conexao->prepare($sql);
                $stm->bindValue(':id', $id);
                $retorno = $stm->execute();

                if ($retorno):
                    echo "<div class='alert alert-success' role='alert'>Registro excluído com sucesso, aguarde você está sendo redirecionado ...</div> ";
                else:
                    echo "<div class='alert alert-danger' role='alert'>Erro ao excluir registro!</div> ";
                endif;

                echo "<meta http-equiv=refresh content='3;URL=lista_produtos.php'>";
            endif;
            ?>
        </div>   
    </body>
</html>
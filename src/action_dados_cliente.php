  <?php require 'cabecalho.php'; ?>
                
        <div class='container box-mensagem-crud'>
        <div class="shadow-lg p-3 mb-5 bg-red rounded bg-gradient-danger">
            <?php            

            // Atribui uma conexão PDO
            $conexao = conexao::getInstance();
            
            $id_cliente = (isset ( $_GET ['id'] )) ? $_GET ['id'] : '';

            // Recebe os dados enviados pela submissão
            $acao = 		(isset($_POST['acao'])) ? $_POST['acao'] : '';
            $id = 			(isset($_POST['id'])) ? $_POST['id'] : '';
            $dtcadastro = 	(isset($_POST['dtcadastro'])) ? $_POST['dtcadastro'] : '';
            $nome = 		(isset($_POST['nome'])) ? $_POST['nome'] : '';
            $ativo = 		(isset($_POST['ativo'])) ? $_POST['ativo'] : '';            
            $dtnascimento = (isset($_POST['dtnascimento'])) ? $_POST['dtnascimento'] : '';
            $sexo = 		(isset($_POST['sexo'])) ? $_POST['sexo'] : '';            
            $cpf = 			(isset($_POST['cpf'])) ? $_POST['cpf'] : '';            

            // Valida os dados recebidos
            $mensagem = '';
            if ($acao == 'editar' && $id == ''):
                $mensagem .= '<li>ID do registros desconhecido.</li>';
            endif;

            // Se for ação diferente de excluir valida os dados obrigatórios
            if ($acao != 'excluir'):
                if ($nome == '' || strlen($nome) < 3):
                    $mensagem .= '<li>Favor preencher a Nome.</li>';
                endif;

                if ($dtnascimento == ''):
                    $mensagem .= '<li>Favor preencher a Data de Nascimento.</li>';
                endif;

                if ($sexo == ''):
                    $mensagem .= '<li>Favor preencher o Sexo.</li>';
                endif;

                if ($cpf == ''):
                    $mensagem .= '<li>Favor preencher o CPF.</li>';
                endif;                                     

                if ($mensagem != ''):
                    $mensagem = '<ul>' . $mensagem . '</ul>';
                    echo "<div class='alert alert-danger' role='alert'>" . $mensagem . "</div> ";
                    exit;
                endif;
            endif;
            // Verifica se foi solicitada a inclusão de dados
            if ($acao == 'incluir'):
                
               
                $cpf = $_POST['cpf'];
                
                $odb = new PDO('mysql:host=localhost;dbname=carselect', 'root', '');
                $odb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $searcha = $odb->query("SELECT * FROM cliente WHERE cpf = '$cpf' ")->fetchColumn();
                

                if ($searcha == '') : // não for maior que zero
                    $sql = 'INSERT INTO cliente (dtcadastro, ativo, nome, dtnascimento, sexo, cpf)
							   VALUES(:dtcadastro, :ativo, :nome, :dtnascimento, :sexo, :cpf)';

                    $stm = $conexao->prepare($sql);
                    $stm->bindValue(':dtcadastro', $dtcadastro);
                    $stm->bindValue(':ativo', $ativo);
                    $stm->bindValue(':nome', $nome);
                    $stm->bindValue(':dtnascimento', $dtnascimento);
                    $stm->bindValue(':sexo', $sexo);                   
                    $stm->bindValue(':cpf', $cpf);                                      
                    $retorno = $stm->execute();

                    if ($retorno):
                        echo "<div class='alert alert-success' role='alert'>Registro inserido com sucesso, aguarde você está sendo redirecionado ...</div> ";
                    else:
                        echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div> ";
                    endif;
                else:
                    echo "<div class='alert alert-danger' role='alert'>Cliente já cadastrado no Sistema!</div> ";                 
              
                endif;
                
                $odb = new PDO('mysql:host=localhost;dbname=carselect', 'root', '');
                $odb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $result = $odb->query("SELECT MAX(idcliente) FROM cliente ORDER BY idcliente DESC")->fetchColumn();               
                
                echo "<meta http-equiv=refresh content='3;URL=frm_cad_end_cliente.php?id=$result'>";
            endif;




            // Verifica se foi solicitada a edição de dados
            if ($acao == 'editar'):
                
                $sql = 'UPDATE cliente SET nome=:nome, dtnascimento=:dtnascimento, ativo=:ativo, sexo=:sexo';
                $sql .= 'WHERE idcliente = :id';

                $stm = $conexao->prepare($sql);
                $stm->bindValue(':dtcadastro', $dtcadastro);
                $stm->bindValue(':ativo', $ativo);
                $stm->bindValue(':nome', $nome);
                $stm->bindValue(':dtnascimento', $dtnascimento);
                $stm->bindValue(':sexo', $sexo);
                $stm->bindValue(':cpf', $cpf);
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
                $sql = 'DELETE FROM tab_produtos WHERE id = :id';
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
        </div>
          
    </body>
</html>
<?php  require 'cabecalho.php'; ?>
        <div id="push"></div>          
            <div style="width: 80%; float:left; background-color: #5cb85c;">
                <div class='container box-mensagem-crud'>
                    <?php

                    // Atribui uma conexão PDO
                    $conexao = conexao::getInstance();

                    // Recebe os dados enviados pela submissão
                    $acao           = (isset($_POST['acao'])) ? $_POST['acao'] : '';
                    $id             = (isset($_POST['id'])) ? $_POST['id'] : '';
                    $nomeempresa    = (isset($_POST['nomeempresa'])) ? $_POST['nomeempresa'] : '';
                    $cnpj           = (isset($_POST['cnpj'])) ? $_POST['cnpj'] : '';
                    $ie             = (isset($_POST['ie'])) ? $_POST['ie'] : '';
                    $logo_atual     = (isset($_POST['foto_atual'])) ? $_POST['foto_atual'] : '';
                    $logradouro     = (isset($_POST['logradouro'])) ? $_POST['logradouro'] : '';
                    $numero         = (isset($_POST['numero'])) ? $_POST['numero'] : '';
                    $complemento    = (isset($_POST['complemento'])) ? $_POST['complemento'] : '';
                    $bairro         = (isset($_POST['bairro'])) ? $_POST['bairro'] : '';
                    $cidade         = (isset($_POST['cidade'])) ? $_POST['cidade'] : '';
                    $uf             = (isset($_POST['uf'])) ? $_POST['uf'] : '';
                    $cep            = (isset($_POST['cep'])) ? $_POST['cep'] : '';


                    // Valida os dados recebidos
                    $mensagem = '';
                    if ($acao == 'editar' && $id == ''):
                        $mensagem .= '<li>ID do registros desconhecido.</li>';
                    endif;

                    // Se for ação diferente de excluir valida os dados obrigatórios
                    if ($acao != 'excluir'):
                        if ($nomeempresa == '' || strlen($nomeempresa) < 3):
                            $mensagem .= '<li>Favor preencher a Descrição.</li>';
                        endif;

                        if ($mensagem != ''):
                            $mensagem = '<ul>' . $mensagem . '</ul>';
                            echo "<div class='alert alert-danger' role='alert'>" . $mensagem . "</div> ";
                            exit;
                        endif;                        
                    endif;
                    // Verifica se foi solicitada a inclusão de dados
                    if ($acao == 'incluir'):

                        $nome_logo = 'logo.jpg';
                        if (isset($_FILES['logo']) && $_FILES['logo']['size'] > 0):

                            $extensoes_aceitas = array('bmp', 'png', 'svg', 'jpeg', 'jpg');
                            $extensao = strtolower(end(explode('.', $_FILES['logo']['nome'])));

                            // Validamos se a extensão do arquivo é aceita
                            if (array_search($extensao, $extensoes_aceitas) === false):
                                echo "<h1>Extensão Inválida!</h1>";
                                exit;
                            endif;

                            // Verifica se o upload foi enviado via POST   
                            if (is_uploaded_file($_FILES['logo']['tmp_name'])):

                                // Verifica se o diretório de destino existe, senão existir cria o diretório  
                                if (!file_exists("img")):
                                    mkdir("img");
                                endif;

                                // Monta o caminho de destino com o nome do arquivo  
                                $nome_logo = date('dmY') . '_' . $_FILES['logo']['name'];

                                // Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino  
                                if (!move_uploaded_file($_FILES['foto']['tmp_name'], 'img/' . $nome_logo)):
                                    echo "Houve um erro ao gravar arquivo na pasta de destino!";
                                endif;
                            endif;
                        endif;

                        $sql = 'INSERT INTO empresa (nomeempresa, cnpj, ie, logradouro, numero, complemento, bairro, cidade, uf, cep, logo)
					      VALUES(:nomeempresa, :cnpj, :ie, :logradouro, :numero, :complemento, :bairro, :cidade, :uf, :cep, :logo)';

                        $stm = $conexao->prepare($sql);
                        $stm->bindValue(':nomeempresa', $nomeempresa);
                        $stm->bindValue(':cnpj', $cnpj);
                        $stm->bindValue(':ie', $ie);
                        $stm->bindValue(':logradouro', $logradouro);
                        $stm->bindValue(':numero', $numero);                        
                        $stm->bindValue(':complemento', $complemento);
                        $stm->bindValue(':bairro', $bairro);
                        $stm->bindValue(':cidade', $cidade);
                        $stm->bindValue(':uf', $uf);
                        $stm->bindValue(':cep', $cep);
                        $stm->bindValue(':logo', $nome_logo);
                        $retorno = $stm->execute();

                        if ($retorno):
                            echo "<div class='alert alert-success' role='alert'>Registro inserido com sucesso, aguarde você está sendo redirecionado ...</div> ";
                        else:
                            echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div> ";
                        endif;

                        echo "<meta http-equiv=refresh content='3;URL=cabecalho.php'>";
                    endif;


                    // Verifica se foi solicitada a edição de dados
                    if ($acao == 'editar'):

                        if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0):

                            // Verifica se a foto é diferente da padrão, se verdadeiro exclui a foto antiga da pasta
                            if ($logo_atual <> 'logo.jpg'):
                                unlink("img/" . $logo_atual);
                            endif;

                            $extensoes_aceitas = array('bmp', 'png', 'svg', 'jpeg', 'jpg');
                            $extensao = strtolower(end(explode('.', $_FILES['foto']['name'])));

                            // Validamos se a extensão do arquivo é aceita
                            if (array_search($extensao, $extensoes_aceitas) === false):
                                echo "<h1>Extensão Inválida!</h1>";
                                exit;
                            endif;

                            // Verifica se o upload foi enviado via POST   
                            if (is_uploaded_file($_FILES['foto']['tmp_name'])):

                                // Verifica se o diretório de destino existe, senão existir cria o diretório  
                                if (!file_exists("img")):
                                    mkdir("img");
                                endif;

                                // Monta o caminho de destino com o nome do arquivo  
                                $nome_logo = date('dmY') . '_' . $_FILES['foto']['name'];

                                // Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino  
                                if (!move_uploaded_file($_FILES['foto']['tmp_name'], 'img/' . $nome_logo)):
                                    echo "Houve um erro ao gravar arquivo na pasta de destino!";
                                endif;
                            endif;
                        else:

                            $nome_logo = $logo_atual;

                        endif;

                        $sql = 'UPDATE empresa SET descricao=:descricao, tipo=:tipo, tamanho=:tamanho, estoque_minimo=:estoque_minimo, estoque_maximo=:estoque_maximo, status=:status, foto=:foto ';
                        $sql .= 'WHERE id = :id';

                        $stm = $conexao->prepare($sql);
                        $stm->bindValue(':nomeempresa', $nomeempresa);
                        $stm->bindValue(':cnpj', $cnpj);
                        $stm->bindValue(':ie', $ie);
                        $stm->bindValue(':logradouro', $logradouro);
                        $stm->bindValue(':numero', $numero);                        
                        $stm->bindValue(':complemento', $complemento);
                        $stm->bindValue(':bairro', $bairro);
                        $stm->bindValue(':cidade', $cidade);
                        $stm->bindValue(':uf', $uf);
                        $stm->bindValue(':cep', $cep);
                        $stm->bindValue(':logo', $nome_logo);
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

                        // Captura o nome da foto para excluir da pasta
                        $sql = "SELECT foto FROM tab_produtos WHERE id = :id AND foto <> 'padrao.jpg'";
                        $stm = $conexao->prepare($sql);
                        $stm->bindValue(':id', $id);
                        $stm->execute();
                        $cliente = $stm->fetch(PDO::FETCH_OBJ);

                        if (!empty($cliente) && file_exists('fotos/' . $cliente->foto)):
                            unlink("img/" . $cliente->foto);
                        endif;

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
        </div>
    </body>
</html>
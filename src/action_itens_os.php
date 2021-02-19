            <?php include 'cabecalho.php'; ?>

<div id="push"></div>
<div class='container box-mensagem-crud'>
            <?php

            $conexao = conexao::getInstance();

            $acao = (isset($_POST['acao'])) ? $_POST['acao'] : '';
            $idos = (isset($_POST['idos'])) ? $_POST['idos'] : '';           
            $idcliente = (isset($_POST['idcliente'])) ? $_POST['idcliente'] : '';
            $idveiculo = (isset($_POST['idveiculo'])) ? $_POST['idveiculo'] : '';
            $descricao = (isset($_POST['descricao'])) ? $_POST['descricao'] : '';
            $tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
            $valor = (isset($_POST['valor'])) ? $_POST['valor'] : '';            
            $totalos = (isset($_POST['totalos'])) ? $_POST['totalos'] : '';
            

            // Iniciar a venda para do Cliente
            if ($acao == 'incluir') :

                $odb = new PDO('mysql:host=localhost;dbname=carselect', 'root', '');
                $odb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $searcha = $odb->query("SELECT idcliente, idos, idveiculo, status FROM os WHERE idcliente = $idcliente AND idveiculo = $idveiculo AND idos = $idos AND status = 'ABERTO'")->fetchColumn();

                if ($searcha == '') : // não for maior que zero
                    $sql = "INSERT INTO os (idcliente, idveiculo, dataos, status)
							   VALUES(:idcliente, :idveiculo, now(), 'ABERTO')";

                    $stm = $conexao->prepare($sql);
                    $stm->bindValue(':idcliente', $idcliente); 
                    $stm->bindValue(':idveiculo', $idveiculo); 
                    $retorno = $stm->execute();                    
                    

                    if ($retorno) :
                        echo "<div class='alert alert-success' role='alert'>A OS esta sendo iniciada, aguarde você está sendo redirecionado para adicionar os intens no carrinho ...</div> ";
                    else :
                        echo "<div class='alert alert-danger' role='alert'>Erro ao Iniciar a OS!</div> ";
                    endif;
                else :
                    echo "<div class='alert alert-success' role='alert'>Ja existe uma OS em aberto para esse Cliente, aguarde você está sendo redirecionado para concluir a venda ...</div> ";
                endif;
                echo "<meta http-equiv=refresh content='3;URL=frm_os.php?id=$idcliente&&idos=$idos&&idveiculo=$idveiculo'>";
            endif;

                // Inserir os produtos para a venda
            if ($acao == 'inserir') :

                $sql = 'INSERT INTO vendas_itens (id_produto, id_vendas, qtd, valor, total)
							   VALUES(:id_produto, :id_vendas, :qtd, :valor, :total)';
                $stm = $conexao->prepare($sql);
                $stm->bindValue(':descricao', $descricao);
                $stm->bindValue(':tipo', $tipo);
                $stm->bindValue(':idos', $idos);                
                $stm->bindValue(':valor', $valor);                
                $retorno = $stm->execute();

                if ($retorno) :
                    echo "<div class='alert alert-success' role='alert'>O produto esta sendo adicionado, aguarde você está sendo redirecionado para adicionar os intens no carrinho ...</div> ";
                else :
                    echo "<div class='alert alert-danger' role='alert'>Erro ao Adicionar o produto!</div> ";
                endif;
                echo "<script language='javascript'>history.back()</script>";              
            endif;

                // Ecluir os produtos para a venda
            if ($acao == 'encerrar') :

                $sql = "UPDATE vendas SET status = 'FECHADO', total_vendas =:total_vendas, total_itens =:total_itens WHERE id_vendas=:id_vendas";

                $stm = $conexao->prepare($sql);
                $stm->bindValue(':id_vendas', $id_vendas);
                $stm->bindValue(':total_vendas', $total_vendas);
                $stm->bindValue(':total_itens', $total_itens);
                $retorno = $stm->execute();
                if ($retorno) :
                    echo "<div class='alert alert-success' role='alert'>Venda esta sendo Concluida, aguarde você está sendo redirecionado para adicionar os intens no carrinho ...</div> ";
                else :
                    echo "<div class='alert alert-danger' role='alert'>Erro ao Exluir o produto!</div> ";
                endif;
                echo "<meta http-equiv=refresh content='3;URL=index.php'>";             
        endif;

            ?>
        </div>



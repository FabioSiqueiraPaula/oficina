            <?php include 'cabecalho.php'; ?>

<div id="push"></div>
<div class='container box-mensagem-crud'>
            <?php

            $conexao = conexao::getInstance();          
             
            use Dompdf\Dompdf;
            
            require __DIR__ . "./../vendor/autoload.php";

            $acao = (isset($_POST['acao'])) ? $_POST['acao'] : '';
            $idos = (isset($_POST['idos'])) ? $_POST['idos'] : '';
            $idos_itens = (isset($_POST['idos_itens'])) ? $_POST['idos_itens'] : '';
            $idcliente = (isset($_POST['idcliente'])) ? $_POST['idcliente'] : '';
            $idveiculo = (isset($_POST['idveiculo'])) ? $_POST['idveiculo'] : '';
            $descricao = (isset($_POST['descricao'])) ? $_POST['descricao'] : '';
            $tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
            $fornecedor = (isset($_POST['fornecedor'])) ? $_POST['fornecedor'] : '';
            $valor = (isset($_POST['valor'])) ? $_POST['valor'] : '';
            $total = (isset($_POST['total'])) ? $_POST['total'] : '';
            $totalpecas = (isset($_POST['totalpecas'])) ? $_POST['totalpecas'] : '';
            $totalservicos = (isset($_POST['totalservicos'])) ? $_POST['totalservicos'] : '';
            $valoracrecimo = (isset($_POST['valoracrecimo'])) ? $_POST['valoracrecimo'] : '';
            $totalacrecimo = (isset($_POST['totalacrecimo'])) ? $_POST['totalacrecimo'] : '';
            $totalos = (isset($_POST['totalos'])) ? $_POST['totalos'] : '';   
            $status = (isset($_POST['status'])) ? $_POST['status'] : '';

            // Iniciar a venda para do Cliente
            if ($acao == 'incluir') :

                $odb = new PDO('mysql:host=localhost;dbname=carselect', 'root', '');
                $odb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $searcha = $odb->query("SELECT idcliente, idos, idveiculo, status FROM os WHERE idcliente = $idcliente AND idveiculo = $idveiculo AND status = 'ABERTO'")->fetchColumn();

                if ($searcha == '') : // não for maior que zero
                    $sql = "INSERT INTO os (idcliente, idveiculo, dataos, status)
							   VALUES(:idcliente, :idveiculo, now(), 'ABERTO')";

                    $stm = $conexao->prepare($sql);
                    $stm->bindValue(':idcliente', $idcliente); 
                    $stm->bindValue(':idveiculo', $idveiculo); 
                    $retorno = $stm->execute();
                    
                    $searchaos = $odb->query("SELECT max(idos) FROM os WHERE idcliente = $idcliente AND idveiculo = $idveiculo AND status = 'ABERTO'")->fetchColumn();
                    
                    if ($retorno) :
                        echo "<div class='alert alert-success' role='alert'>A OS esta sendo iniciada, aguarde você está sendo redirecionado para adicionar os intens na OS ...</div> ";
                    else :
                        echo "<div class='alert alert-danger' role='alert'>Erro ao Iniciar a OS!</div> ";
                    endif;
                else :
                    echo "<div class='alert alert-success' role='alert'>Ja existe uma OS em aberto para esse Cliente, aguarde você está sendo redirecionado para concluir a venda ...</div> ";
                endif;
                echo "<meta http-equiv='refresh' content='4;URL=frm_os.php?id=$idcliente&&idos=$searchaos&&idveiculo=$idveiculo'>";
            endif;
            
            if ($searcha != '') :
            echo "<meta http-equiv='refresh' content='4;URL=frm_os.php?id=$idcliente&&idos=$searchaos&&idveiculo=$idveiculo'>";
            endif;
            

                // Inserir Itens para a OS
            if ($acao == 'inserir') :

                $sql = 'INSERT INTO os_itens (idos, tipo, descricao, valor, valoracrecimo, fornecedor, total)
							           VALUES(:idos, :tipo, :descricao, :valor, :valoracrecimo, :fornecedor, :total)';
                $stm = $conexao->prepare($sql);
                $stm->bindValue(':idos', $idos); 
                $stm->bindValue(':descricao', $descricao);                
                $stm->bindValue(':tipo', $tipo);                                
                $stm->bindValue(':valor', $valor);
                $stm->bindValue(':valoracrecimo', $valoracrecimo);
                $stm->bindValue(':total', $total);
                $stm->bindValue(':fornecedor', $fornecedor);
                $retorno = $stm->execute();

                if ($retorno) :
                    echo "<div class='alert alert-success' role='alert'>O Servico / Pecas esta sendo adicionado, aguarde você está sendo redirecionado para adicionar os intens no carrinho ...</div> ";
                else :
                    echo "<div class='alert alert-danger' role='alert'>Erro ao Adicionar o Pecas / Servicos!</div> ";
                endif;
                echo "<script language='javascript'>history.back(2)</script>";              
            endif;

                // Ecluir os produtos para a venda
            if ($acao == 'encerrar') :

                $sql = "UPDATE os SET idos =:idos, status =:status, totalservicos =:totalservicos, totalpecas =:totalpecas, totalacrecimo =:totalacrecimo, totalos =:totalos WHERE idos =:idos";

                $stm = $conexao->prepare($sql);
                $stm->bindValue(':idos', $idos);                
                $stm->bindValue(':status', $status);
                $stm->bindValue(':totalservicos', $totalservicos);
                $stm->bindValue(':totalpecas', $totalpecas);
                $stm->bindValue(':totalacrecimo', $totalacrecimo);
                $stm->bindValue(':totalos', $totalos);
                $retorno = $stm->execute();
                
                if ($retorno) :
                    echo "<div class='alert alert-success' role='alert'>A OS esta sendo Concluida, aguarde você está sendo redirecionado tela de Clientes ...</div> ";
                else :
                    echo "<div class='alert alert-danger' role='alert'>Erro ao Exluir o produto!</div> ";
                endif;               
              echo "<meta http-equiv='refresh' content='3;URL=relatorios/print_os.php?idos=$idos'>";
        endif;
        
        if ($acao == 'excluir'):        
        // Exclui o registro do banco de dados
        $sql = 'DELETE FROM os_itens WHERE idos_itens = :idos_itens';
        $stm = $conexao->prepare($sql);
        $stm->bindValue(':idos_itens', $idos_itens);
        $retorno = $stm->execute();
        
        if ($retorno):
        echo "<div class='alert alert-success' role='alert'>Registro exclu�do com sucesso, aguarde voc� est� sendo redirecionado ...</div> ";
        else:
        echo "<div class='alert alert-danger' role='alert'>Erro ao excluir registro!</div> ";
        endif;
        echo "<script language='javascript'>history.back(2)</script>"; 
        endif;

            ?>
        </div>




<div id="conteudoDir">
<?php


$result = count($cadastroSemLimit) / 3;
$result = ceil($result);
$prox = $pagina+1;
$ant = $pagina-1;
?>
    <div id="listaPessoas">
        <h1>Cadastros</h1>
        <form action="<?php echo APP."cadastro/excluir"?>" method="post" id="formExcluir">
            <a href="javascript:excluir();" class="btPadraoExcluir">Excluir</a>

            <div class="table-responsive-sm">
                <table id="tLista" class="table table-striped table-dark table-bordered table-responsive">
                    <tr>
                        <th width="5%"><input type="checkbox" class="checkbox" id="select_all" /></th>
                        <th width="5%">ID</th>
                        <th width="5%">Foto</th>
                        <th class="tL">Nome</th>
                        <th width="15%">Dt Nasc</th>
                        <th width="25%">Email</th>
                        <th width="7%">Dep</th>
                        <th width="7%">St</th>
                    </tr>
                    <?php
                    
                        $i = 0; //contador para mudar bgColor
                        foreach ($cadastros as $cadastro) {//exibir lista
                            $btnStatus = ($cadastro['status'] == 1) ? "btVerde" : "btCinza";//verificar status cadastro
                            echo "
                                <tr>
                                    <td align='center'><input name='chkStatus[]' type='checkbox' class='checkbox'
                                            value='{$cadastro['id']}' id='chk_0' /></td>
                                    <td align='center'>{$cadastro['id']}</td>
                                    <td align='center'><img src='{$cadastro['foto']}' width='40' height='40' /></td>
                                    <td><a href='".APP."cadastro/editar/{$cadastro['id']}' class='linkUser' title='Clique aqui para editar este cadastro.'
                                            id='nm_'>{$cadastro['nome']}</a></td>
                                    <td align='center'>{$cadastro['data_nascimento']}</td>
                                    <td align='center'>{$cadastro['email']}</td>
                                    <td align='center'>
                                        <a href='".APP."dependentes/listar/{$cadastro['id']}' class='btAdicionar'
                                            title='Adicionar dependentes para este cadastro.'></a>
                                    </td>
                                    <td align='center'>
                                        <a href='".APP."cadastro/status/{$cadastro['id']}' class='$btnStatus' title='Ativar/Desativar este cadastro.' id='bol_0'></a>
                                    </td>
                                </tr>
                            ";
                            $i++;
                        }
                    ?>
                </table>
            </div>
        </form>

    </div>

    <div id="paginacao" style="width: 20%; margin: 0 auto; display:block;">
        <?php
            if($pagina != 1){
                echo "
                    <a href='".APP."cadastro/listar/$ant' class='btSeta1'></a>
                ";
            }
        ?>
        <div id="pags"><?php echo $pagina." de ".$result ?></div> 
        <?php
            if($pagina < $result){
                echo "
                    <a href='".APP."cadastro/listar/$prox' class='btSeta2'></a>
                ";
            }
        ?>
        <select onchange="location.href=this.value" id="paginas" style="margin: 2px 15px;">
            <?php
                for($k = 1; $k <= $result; $k++){
                    echo "
                        <option value='".APP."cadastro/listar/".$k."'>$k</option>    
                    ";
                }
            ?>
        </select>
    </div>

</div> <!-- FIM CONTEUDO DIR -->

<script>
    //Função para confirmar e submeter exclusão
    function excluir(){
        var formExcluir = document.querySelector('#formExcluir');
        if(confirm("Deseja mesmo excluir os cadastros selecionados?")){
            formExcluir.submit();
        }       
    }

    //Função para selecionar todos 
    document.querySelector("input[id=select_all]").onclick = function(e) {
    var marcar = e.target.checked;
    var lista = document.querySelectorAll("input");
    for ( var i = 0 ; i < lista.length ; i++ )
        lista[i].checked = marcar;
    };
    
</script>
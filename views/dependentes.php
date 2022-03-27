
<div id="conteudoDir">
    
    <div id="listaPessoas">
        <h1>Dependentes</h1>
        
        <div id="infoDep">

            <div id="fotoCadastro">
                <img src="<?php echo $cadastro['foto']?>"/>
                <table id="tListaCad" class="table table-striped table-bordered">
                    <tr>
                        <td>Nome</td>    
                        <td><?php echo $cadastro['nome']?></td>    
                    </tr>              
                    <tr>
                        <td>Data de Nascimento</td>    
                        <td><?php echo $cadastro['data_nascimento']?></td>    
                    </tr>              
                    <tr>
                        <td>Email</td>    
                        <td><?php echo $cadastro['email']?></td>    
                    </tr>              
                </table>
            </div> 
            
          
            <div id="frmAdicionaDep">
                <form method="post" class="myForm"action="<?php echo APP."dependentes/salvar/{$cadastro['id']}"?>">

                    <div>
                        <label for="cNomeDep">Nome</label><br />
                        <input type="text" class="form-control" name="cNomeDep" id="cNomeDep" />
                    </div>
                    <div>
                        <label for="cDataNasc">Data de Nascimento</label><br />
                        <input type="date" name="cDataNasc" class="form-control" id="cDataNasc" />
                    
                    </div>

                    <button class="btnAddDependentes" type="submit">Adicionar</button>

                </form>
           
            </div>
            
            <table class="table table-striped table-dark table-bordered">
                <tr>
                    <th width="60%">Nome do Dependente</th>
                    <th width="33%">Data de Nascimento</th>
                    <th></th>
                </tr>    
                <?php
                    foreach($dependentes as $aux){
                        echo "
                        <tr>
                            <td>{$aux['nome']}</td>
                            <td align='center'>{$aux['data_nascimento']}</td>
                            <td align='center'><a href='".APP."dependentes/excluir/{$aux['id']}' class='btRemover'></a></td>
                        </tr>    
                        ";
                        if($aux == 0){
                            echo "
                            <tr>
                                <td> Vazio </td>
                                <td align='center'>{$aux['data_nascimento']}</td>

                            </tr>
                            ";   
                        }
                    }
                    
                ?>
            </table>
            
            <a href="<?php echo APP."cadastro/listar/1"?>" class="btn btn-primary">Salvar</a>
        </div>
        
    </div>    

</div>

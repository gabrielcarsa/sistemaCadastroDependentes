<div id="conteudoDir">

    <div id="listaPessoas">
    
        <h1>Editando um Cadastro</h1>
        
        <form id="formCadastrar" method="post" enctype="multipart/form-data" action="<?php echo APP?>cadastro/salvar">
            
            <input type="hidden" name="id" value="<?php echo ($cadastro['id'] == 0) ? $data['id'] : $cadastro['id'] ?>">

            <label for="cNome">Nome</label>
            <input id="cNome" name="cNome" class="form-control <?php echo (isset($data['erroNome'])) ? 'is-invalid' : ''; ?>" value="<?php echo $cadastro['nome']?>"/>
            <div class="invalid-feedback"><?php echo $data['erroNome'];?></div>
            
            <label for="cDataNasc">Data de Nascimento</label>
            <input id="cDataNasc" type="date" class="form-control <?php echo (isset($data['erroDataNasc'])) ? 'is-invalid' : ''; ?>" name="cDataNasc" value="<?php echo $cadastro['data_nascimento']?>"/>
            <div class="invalid-feedback"><?php echo $data['erroDataNasc'];?></div>
            
            <label for="cEmail">E-Mail</label>
            <input id="cEmail" name="cEmail" class="form-control <?php echo (isset($data['erroEmail'])) ? 'is-invalid' : ''; ?>" value="<?php echo $cadastro['email']?>" />
            <div class="invalid-feedback"><?php echo $data['erroEmail'];?></div>
            
            <label for="cFoto">Foto (somente .jpg - máximo de 100Kb)</label>
            <input id="cFoto" name="cFoto" class="form-control <?php echo (isset($data['erroFoto'])) ? 'is-invalid' : ''; ?>" type="file" accept="image/jpeg" />
            <div class="invalid-feedback"><?php echo $data['erroFoto'];?></div>

        </form>
        <span style="color: red;">
            <?php
                if($errors != null){
                    echo $errors;
                }
                ?>
        </span>
        <a href="javascript:submeter();" class="btn btn-primary">Salvar</a>
    
    </div>

</div> <!-- FIM CONTEUDO DIR -->

<script>
        //Função para confirmar e submeter exclusão
        function submeter(){
        var formExcluir = document.querySelector('#formCadastrar');
        formExcluir.submit();   
    }</script>


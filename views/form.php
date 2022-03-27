
<div id="conteudoDir">

    <div id="listaPessoas">
        <h1>Incluindo um Novo Cadastro <?php echo $data['erroNome']?></h1>
        
        <form id="formCadastrar" method="post" enctype="multipart/form-data" action="<?php echo APP?>cadastro/salvar">
        
            <label for="cNome">Nome</label><br />
            <input name="cNome" class="form-control <?php echo (isset($data['erroNome'])) ? 'is-invalid' : ''; ?>" value="<?php echo (isset($data['nomeCampo'])) ? $data['nomeCampo'] : ''; ?>"/>
            <div class="invalid-feedback"><?php echo $data['erroNome'];?></div>
        
            <label for="cDataNasc">Data de Nascimento</label><br />
            <input id="cDataNasc" class="form-control <?php echo (isset($data['erroDataNasc'])) ? 'is-invalid' : ''; ?>" type="date" value="<?php echo (isset($data['dataCampo'])) ? $data['dataCampo'] : ''; ?>" name="cDataNasc" />
            <div class="invalid-feedback"><?php echo $data['erroDataNasc'];?></div>
        
            <label for="cEmail">E-Mail</label><br />
            <input id="cEmail" class="form-control <?php echo (isset($data['erroEmail'])) ? 'is-invalid' : ''; ?>" type="email" name="cEmail" value="<?php echo (isset($data['emailCampo'])) ? $data['emailCampo'] : ''; ?>"/>
            <div class="invalid-feedback"><?php echo $data['erroEmail'];?></div>
        
            <label for="cFoto">Foto (somente .jpg - máximo de 200Kb)</label><br />
            <input type="file" id="cFoto" name="cFoto" class="form-control  <?php echo (isset($data['erroFoto'])) ? 'is-invalid' : ''; ?>" type="file" accept="image/jpeg">
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



<?php
    class CadastroController extends Controller{
        //Função para listar Cadastros
        function listar($page){
            $model = new Cadastro();//cria novo objeto Cadastro do Banco de Dados(Models)
            $cadastros_limit = $model->readLimit($page);//faz o objeto Cadastro obtenha uma consulta na model com limit
            $cadastros = $model->read();//faz consulta sem limit
            $data = array();//cria uma array data, do inglês, dados
            $data['cadastros'] = $cadastros_limit;//passa para array consulta obtida com limit
            $data['pagina'] = $page;//passa valor da página atual
            $data['cadastroSemLimit'] = $cadastros;//passa consulta total sem clausula limit
            $this->view("lista", $data);//cria uma rota para lista.php
        }

        //Função para mudar status Cadastros
        function status($id){
            $model = new Cadastro();
            $cadastro = $model->getById($id);//obtém dado do cadastro através do id
            if($cadastro['5'] == "1"){//se status for igual a 1(true) ///// $cadastro['5'] é o status
                $arr = array();//array para alterar status
                $arr['status'] = 0;//muda status
                $arr['id'] = $cadastro['id'];//passa o id para array
                $model->update($arr);//passa a função atualizar como parâmetro o array de dados para o update
                $this->redirect("cadastro/listar/1");//redireciona de volta para listagem
            } elseif($cadastro['5'] == "0"){//se status for igual a 0(false)
                $arr = array();
                $arr['status'] = 1;
                $arr['id'] = $cadastro['id'];
                $model->update($arr);
                $this->redirect("cadastro/listar/1");
            }else{
                //operação inválida
                $this->redirect("cadastro/listar/1");
            }
        }

        //Função para excluir Cadastros
        function excluir() {
            $model = new Cadastro();
            $arrCheckbox = $_POST['chkStatus'];//obtém todos os checkbox checkados
            foreach($arrCheckbox as $aux){//percorre por eles excluindo os selecionados
                $model->delete($aux);//exclui
            }
            $this->redirect("cadastro/listar/1");//redireciona
        }

        //Função para redirecionar para formulário Cadastros
        function novo() {
            $this->view("form", $data);//cria uma rota para form.php
        }

        //Função para salvar no BD
        function salvar() {
            $error = false;
            $data = array();//array de dados para passar de volta para view
            $cadastro = array();//array para armazenar informações e salvar
            $cadastro['id'] = isset($_POST['id']) ? $_POST['id'] : 0;  

            //Verficar campo nome
            if(empty(trim($_POST["cNome"]))){
                $err = "Por favor insira um nome.";//string Erro
                $data['erroNome'] = $err;
                
            }else{
                $data['nomeCampo'] = $_POST['cNome'];//armazenar informção se estiver correta
                $cadastro['nome'] = $_POST['cNome'];//gravar em array para salvar
            }

            //Verficar campo data
            $aux = explode('-', $_POST['cDataNasc']);//quebrar data na aparição de '-'
            $ano = $aux[0];//pegar ano  
            intval($ano);//transformar em inteiro
            if(empty(trim($_POST["cDataNasc"]))){
                $err = "Por favor insira uma data.";   
                $data['erroDataNasc'] = $err;
               
            }elseif($ano < 1902){//verifica se não tem mais que 120 ano                         
                $err = "Por favor insira uma data com menos de 120 anos.";
                $data['erroDataNasc'] = $err;
                
            }else{//Se tudo estiver certo
                $data['dataCampo'] = $_POST['cDataNasc'];
                $cadastro['data_nascimento'] = $_POST['cDataNasc'];
            }

            //verificar campo email
            if(empty(trim($_POST["cEmail"]))){
                $err = "Por favor insira um email.";   
                $data['erroEmail'] = $err;
            
            }elseif(!filter_var(trim($_POST["cEmail"]), FILTER_VALIDATE_EMAIL ) ) {//validando email com função php
                $err = "Por favor insira um email válido.";   
                $data['erroEmail'] = $err;
            
            }else{
                $data['emailCampo'] = $_POST['cEmail'];
                $cadastro['email'] = $_POST['cEmail'];
            }

            //Valida campo foto
            if($_FILES['cFoto']['size'] > 204800){//200*1024 tamanho da img
                $err = "Por favor insira uma imagem menor que 200kb.";   
                $data['erroFoto'] = $err;
            
            }elseif($_FILES['cFoto']['size'] > 0){
                $img = $_FILES['cFoto'];
                $nome_img = $img['name'];//obtém nome da img

                $novoNome_img = preg_replace('/\s+/', '',$cadastro['nome']);//Tira qualquer espaços do nome
                $extensao = strtolower(pathinfo($nome_img, PATHINFO_EXTENSION));//Retira o tipo de arquivo
                $caminho = "public/images/".$novoNome_img.".".$extensao;//Define o caminho para o diretório
                if (!move_uploaded_file($img['tmp_name'], $caminho)) {
                    $err = "Não foi possível fazer upload da imagem.";   
                    $data['erroFoto'] = $err;
            
                }
                $cadastro['foto'] = APP.$caminho;
            }    

            //Última Verificação para não salvar vazio
            if(!isset($data['erroNome']) && !isset($data['erroDataNasc']) && !isset($data['erroEmail']) && !isset($data['erroFoto'])){
                $cadastro['status'] = 1;//sempre inicia cadastro como ativo
        
                $model = new Cadastro();
                if ($cadastro['id'] == 0) {//se id for 0, cria, senão altera
                $model->create($cadastro);
                } else {
                $model->update($cadastro);
                }
                $this->redirect("cadastro/listar/1");
            }else{
                if($cadastro['id'] != 0){//verifica qual formulario esta validando, se pe o editar ou o form
                    $data['id'] = $cadastro['id'];
                    $this->view("editar", $data);
                }else{
                    $this->view("form", $data);
                }
            }
        }
      
        //Função que edita dados do Cadastro
        function editar($id) {
            $model = new Cadastro();
            $cadastro = $model->getById($id);
            $dados = array();
            $dados['cadastro'] = $cadastro;
            $this->view('editar', $dados);
        }
      
        
    }
?>
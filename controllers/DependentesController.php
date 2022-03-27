<?php
    class DependentesController extends Controller{
        //Função para listar dependentes
        function listar($id){
            $modelCadastro = new Cadastro();//instacia novo objeto Cadastro dependente do Banco de Dados(Models)
            $cadastro = $modelCadastro->getById($id);//obtém dados do cadastro
            $modelDependente = new Dependente();
            $dependente = $modelDependente->readDependente($id);//obtém dados dos dependentes
            $data = array();//cria uma array data, do inglês, dados
            $data['cadastro'] = $cadastro;//passa posição com array dos cadastros obtidos
            $data['dependentes'] = $dependente;
            $this->view("dependentes", $data);//cria uma rota para lista.php
        }

        //Função para excluir dependentes
        function excluir($id) {
            $model = new Dependente();
                $this->redirect("dependentes/listar/$id");
                $dependente = $model->getById($id);//obtém dados pelo id
            $model->delete($id);//exclui
            $cadastro_id = $dependente['cadastro_id'];//passa chave estrangeira com id de cadastros para dependentes
            $this->redirect("dependentes/listar/$cadastro_id");//redireciona
        }

        //Função para salvar no dependentes no BD
        function salvar($id) {
            $dados = array();

            //Validar campo nome
            if(empty(trim($_POST["cNomeDep"]))){
                $err = "Por favor insira um nome.";//string Erro
                echo "
                <script>
                    if(confirm('".$err."')){
                        window.location.href = '".APP."dependentes/listar/$id';
                    }
                </script>;";
            }else{
                $dados['nome'] = $_POST["cNomeDep"];
            }
            
            
            //Verficar campo data
            $aux = explode('-', $_POST['cDataNasc']);//quebrar data na aparição de '-'
            $ano = $aux[0];//pegar ano  
            intval($ano);//transformar em inteiro
            if(empty(trim($_POST["cDataNasc"]))){
                $err = "Por favor insira uma data de Nascimento.";//string Erro
                echo "
                <script>
                    if(confirm('".$err."')){
                        window.location.href = '".APP."dependentes/listar/$id';
                    }
                </script>;";
            }elseif($ano < 1902){//verifica se não tem mais que 120 ano                         
                $err = "Por favor insira uma data de nascimento menor que 120 anos.";//string Erro
                echo "
                <script>
                    if(confirm('".$err."')){
                        window.location.href = '".APP."dependentes/listar/$id';
                    }
                </script>;";
            }else{
                $dados['data_nascimento'] = $_POST["cDataNasc"];
                $dados['cadastro_id'] = $id;
                $model = new Dependente();
                $model->create($dados);
                $this->redirect("dependentes/listar/$id");
            }           

        }
        
    }
?>
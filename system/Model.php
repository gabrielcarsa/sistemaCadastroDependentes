<?php
  abstract class Model {
    protected $table = "";//Definir nome da tabela
    protected $query = "";//Definir sql

    //Função para obter conexão com o BD
    function getConnection() {
        $username = 'root';
        $password = '0406carsa';
        $database = 'quality';
        $host = 'localhost';
        try {
            $conn = new PDO('mysql:host='.$host.';port=5432;dbname='.$database, $username, $password);
            return $conn;
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    //Função para adicionar dados no BD
    function create($data) {

        // data = ['id': 0, 'nome': 'Gabriel Henrique'];

        if (isset($data['id'])) {
            // remove a key id do array data
            unset($data['id']);
        }

        //[0: 'nome']
        $keys = array_keys($data);

        // obtém o valor dos campos da tabela, Ex.: 'nome'
        $campos = implode(", ", $keys);

        // coloca um ':' antes do campo para usar o Bind do PDO, Ex.:':nome'
        $valores = ":".implode(", :", $keys);

        $sql = "INSERT INTO $this->table ($campos) values ($valores) ";
        $conn = $this->getConnection();//obtém conexão
        $stmt = $conn->prepare($sql);//prepara sql
        //ForEach para colocar campos e chaves
        foreach($keys as $key) {
            $stmt->bindParam(":$key", $data[$key]);
        }

        //Executa
        $stmt->execute();
    }

    //Função para ler dados do BD
    function read() {
        $conn = $this->getConnection();//obtém conexão
        
        //Operador ternário para verificar se existe uma query preparada ou não
        $sql = $this->query != "" ?  $sql = $this->query : "select * from $this->table";
        
        //Executa query
        $stmt = $conn->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    //Função para ler dados do BD com Limit(paginação)
    function readLimit($page) {
        $conn = $this->getConnection();//obtém conexão
        $offset = ($page - 1) * 3;
        $sql = "select * from $this->table ORDER BY id LIMIT 3 OFFSET $offset";
    
        //Executa query
        $stmt = $conn->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    //Função para ler dados do BD
    function readDependente($id_cadastro) {
        $conn = $this->getConnection();//obtém conexão
        
        $sql = "select * from $this->table where cadastro_id = $id_cadastro";
        
        //Executa query
        $stmt = $conn->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    //Função para atualizar dados no BD
    function update($data) {
        // 0: id, 1: nome, 2:email ...

        $keys = array_keys($data);

        $campos = "";

        //ForEach para preparar o Update do BD
        foreach ($keys as $key) {
            if ($key != "id") {
                if ($campos != "") {
                    $campos .= ", $key=:$key";
                } else {
                    $campos = "$key=:$key";
                }
            // campos = 'nome=:nome, email=:email'
            }
        }

        $sql = "UPDATE $this->table SET $campos WHERE id=:id ";
        $conn = $this->getConnection();//obtém conexão
        $stmt = $conn->prepare($sql);

        //ForEach para colocar campos e chaves
        foreach($keys as $key) {
            $stmt->bindParam(":$key", $data[$key]);
        }
        $stmt->execute();
    }

    //Função para deletar no BD
    function delete($id) {
        if($this->table == "cadastro"){//Verifica se cadastro tem dependentes para exclui-los
            $sql = "SELECT COUNT(*) FROM dependentes WHERE cadastro_id = ?";
            $conn = $this->getConnection();//obtém conexão
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $id);//substitui o '?' pelo seu respectivo id
            $stmt->execute();//executa
            $count = $stmt->rowCount();
            
            if($count != 0){//Se houver dependentes excluir
                $sql = "DELETE FROM dependentes WHERE cadastro_id = ? ";
                $conn = $this->getConnection();//obtém conexão
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $id);//substitui o '?' pelo seu respectivo id
                $stmt->execute();//executa
            }

            $aux = $this->getById($id);
            $arquivo = $aux['foto'];
            $arquivo  = explode(APP, $arquivo);
            
            if(file_exists($arquivo[1])){
                $status = unlink($arquivo[1]);
            }
        }
        
        $sql = "DELETE FROM $this->table WHERE id=? ";//sql
        $conn = $this->getConnection();//obtém conexão
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $id);//substitui o '?' pelo seu respectivo id
        $stmt->execute();//executa
    }

    //Função que faz consulta e retorna resultado pelo seu id
    function getById($id) {
        $sql = "SELECT * FROM $this->table WHERE id=? ";
        $conn = $this->getConnection();//obtém conexão
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $id);//substitui o '?' pelo seu respectivo id
        $stmt->execute();
        $data = $stmt->fetch();//coloca um retorno de uma linha de consulta
        return $data;
    }
  }
 ?>

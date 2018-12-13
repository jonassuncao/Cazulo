<?php
/**
 * Gerencia os dados do Condominio
 * 
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 09/11/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              Gerencia os dados do Condominio
 * =================================================================
 * 
 * Dir  - models
 * File - CondominioModel.php
 */

//Importas as libs que serão utilizadas
require_once 'Lib/Utilitarios.php';

class CondominioModel{
    

    /**
     *  Verifica se o 
     * usuário tem permissão para a rota
     */
    public function temPermissaoMudarCondominio($operacao, $CNPJcondominio){                
        return true;
    }

    /**
     * Metodo que busca no banco de dados Nome e CNPJ de todos os condominios cadastrados no sistema
     * @return (Array)Resposta com os dados
     */
    public function getCondominios(){
    
        $resultado = null;

        $campos = "cnpj, razaoSocial";
        $tabela = "condominio";
        
        
        //Cria conexão com o Banco, passa as variaveis como parametros e armazena o resultado em um Array
        $queryCondominios = new BancoDados();                    
        $queryCondominios->select($campos, $tabela);
            
        //Monta um Array para resposta
        $resultado = Array();
        while($linha = $queryCondominios->resultQuery()){                                
            array_push($resultado, Array('cnpj' => mascara($linha['cnpj'], '##.###.###/####-##'), 'nome'=> $linha['razaoSocial']));
        } 
        
        //Caso não retorne nenhum valor, gera uma exceção
        if(empty($resultado)) throw new CondominioVazioException("Não há condomínios para ser listado!");

        //Retorna uma lista de Array("cnpj" => 99.999.999/9999-99, "nome"=>"nome")
        return $resultado;

    }
######################################################################################################################################################################    
    //buscar condominio pelo cnpj e retornar seus dados
    public function listarCondominio($cnpj){

        //-----Inicío da extração dos números do CNPJ
        $cnpj = substr($cnpj, strpos($cnpj, '(')+2, 18);     //O CNPJ foi convertido para o formato: 99.999.999/9999-99        
        $cnpj = str_replace(array('.','/','-'), "", $cnpj);  //O CNPJ foi convertido para o formato: 99999999999999
        //----Fim da extração dos números do CNPJ
        

        //Verifica se CNPJ o cnpj está no formato: 99999999999999 e se possui 14 digítos
        if(!is_numeric($cnpj) || strlen($cnpj) != 14) throw new Exception("CNPJ do condomínio inválido!: $cnpj");

        /**
         * Se chegou até aqui, então o CNPJ está ok. 
         */

        //Define as varíaveis para realizar a busca do condomínio na Tabela Banco         
        $tabela = "condominio";        
        $where = "cnpj = '$cnpj'";

        //Cria conexão com o Banco, passa as variáveis como parâmetro 
        $queryCondominios = new BancoDados();                    
        $queryCondominios->select("*",$tabela, $where);
     
        //Monta um Array para resposta
        $resultado = Array();        
        
        if($query = $queryCondominios->resultQuery()){ //Percorre cada linha da query para pegar o resultado               

            //Extrai os dados da query e coloca no array temporário
            $resultado['cnpj']        = mascara($query['cnpj'], '##.###.###/####-##');
            $resultado['nome']        = $query['razaoSocial'];
            $resultado['telefone']    = $query['telefone'];
            $resultado['celular']     = $query['celular'];
            $resultado['email']       = $query['email'];
            $resultado['cep']         = $query['cep'];
            $resultado['rua']         = $query['rua'];
            $resultado['numero']      = $query['numero'];
            $resultado['setor']       = $query['setor'];
            $resultado['complemento'] = $query['complemento'];
            $resultado['municipio']   = $query['municipio'];
            $resultado['estado']      = $query['estado'];

        } 

        //Caso a variável $resultado, esteja vazia mesmo após tentar extrair os dados da query... Então a query não retornou nenhum dado
        if(empty($resultado)) throw new CondominioVazioException("Não há condomínios para ser listado!");

        //Retorna a lista de condomínio para o model
        //return $resultado;

        
        //Consulta dados do banco
        //Define as varíaveis para realizar a busca do condomínio na Tabela Banco         
        $tabela = "banco";       //<<==Coloca a tabela do banco
        $where = "cnpj = '$cnpj'";     //<<===Arrume o where, para que pegue todos os bancos desse cnj

        //Cria conexão com o Banco, passa as variáveis como parâmetro 
        //$queryCondominios = new BancoDados();    //<<===não é necessário instanciar novamente a classe de BancoDados, podemos usar a classe que foi instanciada para aconsulta de condominio                
        $queryCondominios->select("*",$tabela, $where);
     
        //Monta um Array para resposta
        $resultadoBanco['banco'] = Array();        
        
        //Use um while, pois essa consulta pode retornar mais de 1 linha
        while($query = $queryCondominios->resultQuery()){ //Percorre cada linha da query para pegar o resultado   
            //Crie um array temporário para que você possa extrair os dados de cada linha
                $linha = array();
                
                $linha['nomeBanco']    = $query['nomeBanco'];
                $linha['agencia']  = $query['agencia'];
                $linha['conta']    = $query['conta'];
                $linha['operacao'] = $query['operacao'];

            //Após extrair adicione esse array a lista do condomínio
            array_push($resutadoBanco['banco'], $linha);
        }
        //array_push($resultado,$resultadoBanco)  
       $resultado['banco'] = $resultadoBanco;

        return $resultado;
    }
#######################################################################################################################################################################

    /**
     * Exclui todos os dados de um condomínio e o condomínio
     * 
     * Caso dê erro gera exceção
     * 
     */
    public function deletarCondominio($cnpj){                
        /**
         * O cnpj passadi no parâmetro está no formato: <nome Condominio> (99.999.999/9999-99)
         * o Banco de dados está parametrizado para aceitar apenas o formato: 99999999999999
         * 
         * Para o banco de dados aceitar o cnpj, é necessário extrair apenas os números
         */
        

        //-----Inicío da extração dos números do CNPJ
        $cnpj = substr($cnpj, strpos($cnpj, '(')+2, 18);     //O CNPJ foi convertido para o formato: 99.999.999/9999-99
        $cnpj = str_replace(array('.','/','-'), "", $cnpj);  //O CNPJ foi convertido para o formato: 99999999999999
        //----Fim da extração dos números do CNPJ
        

        //Verifica se CNPJ o cnpj está no formato: 99999999999999 e se possui 14 digítos
        if(!is_numeric($cnpj) || strlen($cnpj) != 14) throw new Exception("CNPJ do condomínio inválido!");

        /**
         * Se chegou até aqui, então o CNPJ está ok.
         * 
         * Agora serão excluidos todos os dados desse condomínio em todas as tabelas do sistema
         * (Nesse caso será excluído apenas da tabela dos Bancos)
         * 
         * Depois será excluído o cadastro do condomínio
         */

         //Define as varíaveis para realizar a exclusão do condomínio na Tabela Banco         
         $tabela = "banco";        
         $where = "cnpj = '$cnpj'";

         //Cria conexão com o Banco, passa as variáveis como parâmetro 
         $queryCondominios = new BancoDados();                    
         $queryCondominios->delete($tabela, $where);
        
         //====Se chegou aqui, excluiu oas contas bancárias do condomínio

         //Define as varíaveis para realizar a exclusão do condomínio na Tabela Condomínio
         $tabela = "condominio";        
           
         $queryCondominios->delete($tabela, $where);

         //====Se chegou aqui, excluiu o condomínio
    }

    public function adicionarCondominio($razaoSocial, $cnpj, $telefone, $celular, $email, $cep, $rua, $numero, $setor, $complemento, $municipio, $estado, $bancos){
        
        $cnpj = str_replace(array('.','/','-'), "", $cnpj);  //O CNPJ foi convertido para o formato: 99999999999999
        //----Fim da extração dos números do CNPJ

        //Verifica se CNPJ o cnpj está no formato: 99999999999999 e se possui 14 digítos
        if(!is_numeric($cnpj) || strlen($cnpj) != 14) throw new Exception("CNPJ inválido!");
        
        //inserir na tabela condominio
        $campos = "razaoSocial, telefone, celular, email, cep, rua, numero, setor, complemento, municipio, estado";
        $valor = Array($razaoSocial, $telefone, $celular, $email, $cep, $rua, $numero, $setor, $complemento, $municipio, $estado);
        $tabela = "condominio";  
        $where = "cnpj = '$cnpj'";      
        
        //Cria conexão com o Banco, passa as variáveis como parâmetro 
        $query = new BancoDados();                    
        $query->update($campos, $valor, $tabela, $where);


        //Atualizar Bancos
        $bancos = explode("|", substr($bancos, 1)); // Converte a string para Array()
        
        foreach ($bancos as $key => $banco) {
                        
            $banc = array();
            $banc['nomeBanco'] = substr($banco, 0, strpos($banco, " -"));
            $banc['agencia']   = substr($banco, strpos($banco, "AG:")+4, (strpos($banco, "C/")-1) - (strpos($banco, "AG:")+4));
            $banc['operacao']  = substr($banco, strpos($banco, "C/"), (strpos($banco, "C/")+1) - (strpos($banco, "C/")-2));
            $banc['conta']     = substr($banco, strpos($banco, "/")+4);

            $bancos[$key] = $banc;        
        }
        
        //Atualiza bancos no banco de dados        
        $tabela = "banco";      

        //Percorre cada linha da do array banco para adicionar/atualizar
        foreach ($bancos as $banco) {
            
            //Verifica se o banco está cadastrado
            $where  = "     cnpj     = '$cnpj'";
            $where .= " and operacao = '".$banco['operacao']."'";    
            $where .= " and agencia  = '".$banco['agencia']."'";    
            $where .= " and conta    = '".$banco['conta']."'";    

            $query->select("*",$tabela, $where);
                                 
            if($result = $query->resultQuery()){ //Percorre cada linha da query para pegar o resultado   
                //Já existe cadastro, então atualiza
                $campos = "nomeBanco";                 
                $valor = Array($banco['nomeBanco']);     

                $where  = "     cnpj     = '$cnpj'";
                $where .= " and operacao = '".$banco['operacao']."'";    
                $where .= " and agencia  = '".$banco['agencia']."'";    
                $where .= " and conta    = '".$banco['conta']."'";    

                $query->update($campos, $valor, $tabela, $where);              
            }else{
                //Não existe cadastro, então adiciona
                $campos = "cnpj, operacao, agencia, conta, nomeBanco"; 
                $valor = Array($cnpj, $banco['operacao'], $banco['agencia'], $banco['conta'], $banco['nomeBanco']);     

                $query->insert($campos, $valor, $tabela);              
            }
        }
        //Terminou de incluir e atualizar os bancos, Agora deve excluir os bancos que não estão sendo usados

        
            
        //Verifica se o banco está cadastrado
        $where = "cnpj = '$cnpj'";      

        $excluir = new BancoDados();                    
        $excluir->select("*",$tabela, $where);
                           
        while($result = $excluir->resultQuery()){ //Percorre cada linha da query para pegar o resultado   
            
            //Verifica se o banco cadastrado ainda existe no array $bancos                
            $podeExclui = true;
            foreach ($bancos as $banco) {
                if($banco['operacao'] == $result['operacao'] && $banco['agencia'] == $result['agencia'] && $banco['conta'] == $result['conta']){
                    
                    $podeExclui = false;
                    break;
                }
            }
            
            if(!$podeExclui) continue; // Se variavel $podeExclui for falso, então não pode excluir o banco
            
            //Se chegou aqui então pode excluir o banco    
            $where  = "     cnpj     = '$cnpj'";
            $where .= " and operacao = '".$result['operacao']."'";    
            $where .= " and agencia  = '".$result['agencia']."'";    
            $where .= " and conta    = '".$result['conta']."'";    
            $excluir->delete($tabela, $where);
        }
        
    }
}

?>
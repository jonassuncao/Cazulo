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
        if(empty($resultado)) throw new Exception("Não há condomínios para ser listado!");

        //Retorna uma lista de Array("cnpj" => 99.999.999/9999-99, "nome"=>"nome")
        return $resultado;

    }
######################################################################################################################################################################    
    //buscar condominio pelo cnpj e retornar seus dados
    public function listarCondominio($cnpj){

        //-----Inicío da extração dos números do CNPJ
        $cnpj = substr($cnpj, strpos($cnpj, '(')+2, 18);     //O CNPJ foi convertido para o formato: 99.999.999/9999-99
        
        //Verifica se CNPJ salvo na Seção == O cnpj passado no parâmetro, Se for diferente... gera Exceção
        if($_SESSION['cnpj'] != $cnpj) throw new Exception("CNPJ do condomínio não é esse!");

        $cnpj = str_replace(array('.','/','-'), "", $cnpj);  //O CNPJ foi convertido para o formato: 99999999999999
        //----Fim da extração dos números do CNPJ
        

        //Verifica se CNPJ o cnpj está no formato: 99999999999999 e se possui 14 digítos
        if(!is_numeric($cnpj) || strlen($cnpj) != 14) throw new Exception("CNPJ do condomínio inválido!");

        /**
         * Se chegou até aqui, então o CNPJ está ok. 
         */

         //Define as varíaveis para realizar a busca do condomínio na Tabela Banco         
         $tabela = "condominio";        
         $where = "cnpj = '$cnpj'";

         //Cria conexão com o Banco, passa as variáveis como parâmetro 
         $queryCondominios = new BancoDados();                    
         $queryCondominios->select("*",$tabela, $where);
     
         return $queryCondominios;
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
        
        //Verifica se CNPJ salvo na Seção == O cnpj passado no parâmetro, Se for diferente... gera Exceção
        if($_SESSION['cnpj'] != $cnpj) throw new Exception("CNPJ do condomínio não é esse!");

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
}

?>
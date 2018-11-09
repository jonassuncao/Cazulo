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
require_once 'lib/BancoDados.php'; //Lib que realiza operação no banco de dados
require_once 'lib/utilitarios.php'; //Lib com funcões utilitarias

class CondominioModel{
    
    /**
     * Metodo busca no banco de dados Nome e CNPJ de todos os condominios cadastrados no sistema
     * @return Array Nome e CNPJ de todos os condominios
     */
    public function getCondominios(&$FLAG){
        $result = null;

        try{ //Tenta realizar a consulta no Banco
            $campos = "cnpj, razaoSocial";
            $tabela = "condominio";

            //Cria conexão com o Banco, passa as variaveis como parametros e armazena o resultado em um Array
            $queryCondominios = new BancoDados();            
            $queryCondominios->select($campos, $tabela);
                
            //Monta um Array para resposta
            $result = Array();
            while($linha = $queryCondominios->resultQuery()){                                
                array_push($result, Array('cnpj' => mascara($linha['cnpj'], '##.###.###/####-##'), 'nome'=> $linha['razaoSocial']));
            } 
            
            /*Atribui a variavel $FLAG = TRUE, ou seja, 
                a operação foi realizada com sucesso, o controller pode encaminhar os dados para a view de listagem            
            */            
            $FLAG = TRUE; 
        }catch(Exception $e){
            //Caso de alguma exceção, monta a resposta
            $result = "Erro ao obter listagem dos condominios!".$e->getMessage();

            /*Atribui a variavel $FLAG = FALSE, ou seja, 
                a operação não foi realizada com sucesso, o controller deve encaminhar os dados para a view de erros            
            */                        
            $FLAG = FALSE;
        }

        return $result;
    }
}

?>
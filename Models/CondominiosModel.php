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
require_once 'lib/Utilitarios.php';

class CondominioModel{
    

    /**
     *  Verifica se o 
     * usuário tem permissão para a rota
     */
    public function temPermissaoMudarCondominio($operacao, $CNPJcondominio){                
        return true;
    }

    /**
     * Metodo busca no banco de dados Nome e CNPJ de todos os condominios cadastrados no sistema
     * @return (Object)Resposta com os dados e o codigo da resposta
     */
    public function getCondominios(){
    
        $resposta = new Resposta();
        $resultado = null;

        try{ //Tenta realizar a consulta no Banco
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
            
            //Armazena o resultado em um objeto
            $resposta->setCodigoResposta(TRUE);
            $resposta->setMensagem($resultado);
        }catch(Exception $e){
            
            //Armazena o erro em um objeto
            $resposta->setCodigoResposta(FALSE);
            $resposta->setMensagem("Erro ao obter listagem dos condominios!".$e->getMessage());            
        }

        return $resposta;
    }
}

?>
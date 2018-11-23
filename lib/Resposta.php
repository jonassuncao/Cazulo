<?php

/**
 * Objeto auxiliar para transferir dados entr classes 
 * 
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 23/11/2018 - @version 0.0.2
 * description: Versão inicial do arquivo, 
 *              Gerando Get's\Set's
 * =================================================================
 * 
 * Dir  - lib
 * File - Resposta.php
 */

class Resposta{
    
    private $codigoResposta;
    private $mensagem;
    
    /**
     * Metodo contrutor 
     * Inicializa as variaveis de conexão com o Banco de Dados
     * E tenta iniciar a conexãocom o Banco
     */
    function __construct() {      
        //Inicializa as variaveis 
        $this->codigoResposta = false;
        $this->mensagem = "";          
    }
        
    public function setCodigoResposta($codigoResposta){ $this->codigoResposta = $codigoResposta;}
    public function setMensagem($mensagem){ $this->mensagem = $mensagem;}

    public function getCodigoResposta(){ return $this->codigoResposta;}
    public function getMensagem(){ return $this->mensagem;}
}

?>
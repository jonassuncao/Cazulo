<?php

/**
 * Gerencia e processa conexão com o Banco de Dados 
 * 
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 09/11/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              Gerencia conexões com o Banco de Dados
 * =================================================================
 * 
 * Dir  - lib
 * File - BancoDados.php
 */

class BancoDados{
    
    private $BD_conexao;
    private $BD_host;
    private $BD_login;
    private $BD_senha;
    private $BD_nome;
    private $Array_fetch;
    
    
    /**
     * Metodo contrutor 
     * Inicializa as variaveis de conexão com o Banco de Dados
     * E tenta iniciar a conexãocom o Banco
     */
    function __construct() {      
        //Inicializa as variaveis de conexão
        $this->BD_host      = "localhost";
        $this->BD_login     = "root";
        $this->BD_senha     = "";
        $this->BD_nome      = "cazulo";
        $this->Array_fetch  = null;
        /*
         * Essa função tenta encontrar um link persistente já aberto, com as variaveis de conexão
         * Se for encontrado usa essa conexão.
         * Senão abre uma nova conexão
         */
        
        $this->BD_conexao = mysql_pconnect($this->BD_host, $this->BD_login, $this->BD_senha);
        
        //Tenta selecionar a BaseDados $this->BD_nome
        mysql_select_db($this->BD_nome);

        //Moda o encoding da conexão para UTF-8
        mysql_set_charset('utf8',$this->BD_conexao);

        //Verifica se conseguiu estabelecer a conexão
        if($this->DB_conexao === false)
            throw new Exception("<br/><br/>Não foi possível conectar com o Banco de Dados! <br/>Motivo: ".utf8_encode(mysql_error())); 
                                
    }
        
    /** 
     * Metodo executa uma query 
     * @param campos  Nome dos campos,  por padrão "*" 
     * @param tabelas Nome das tabelas
     * @param where   Condição
     * @param order   Nome dos campos para serem ordenados
     */
    public function select($campos = "*", $tabelas = "", $where = "", $order = ""){
        $query  = " select ".$campos;                       //Inclui os campos na consulta
        $query .= " from ".$tabelas;                        //Inclui as tabelas
        $query .= ($where != "")? " where ".$where : "";     //Inclui a condição
        $query .= ($order != "")? " order by ".$order : "";  //Inlcui a ordenação

        $query = mysql_query($query, $this->BD_conexao);

        //Verifica se conseguiu realizar a query
        if($query === false)
            throw new Exception("<br/><br/>Não foi possível realizar consulta no Banco Dados! <br/>Motivo: ".utf8_encode(mysql_error()));         

        //Armazena a query em uma variavel fetch
        $this->Array_fetch = $query;
    }

   /** 
     * Metodo percorre a query armazenada na variavel fetch
     * Caso termine de percorrer, limpa a query
     * Caso não tenha terminado retorna uma linha de resultado da query
     */
    public function resultQuery(){
        //Caso chegue no fi
        if($this->Array_fetch === false || $this->Array_fetch === null){ mysql_free_result($this->Array_fetch); return false;}
        return mysql_fetch_array($this->Array_fetch, MYSQL_ASSOC);
    }    
}

?>
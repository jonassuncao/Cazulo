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
    public function select($campos = "*", $tabelas = "", $where = "", $order = "", $inicio = 0, $limit = 10){
        if($limit > 100) $limit = 100; // Definindo o limite de consulta para 100 registros por consuta

        $query  = " select ".$campos;                       //Inclui os campos na consulta
        $query .= " from ".$tabelas;                        //Inclui as tabelas
        $query .= ($where != "")? " where ".$where : "";     //Inclui a condição
        $query .= ($order != "")? " order by ".$order : "";  //Inlcui a ordenação
        $query .= " limit ".$inicio.", ".($inicio+$limit);

        $query = mysql_query($query, $this->BD_conexao);

        //Verifica se conseguiu realizar a query
        if($query === false)
            throw new Exception("<br/><br/>Não foi possível realizar consulta no Banco Dados! <br/>Motivo: ".utf8_encode(mysql_error()));         

        //Armazena a query em uma variavel fetch
        $this->Array_fetch = $query;
    }

   /** 
     * Metodo executa uma query 
     * @param Array campos campos  Nome dos campos,  por padrão "*" 
     * @param Array valores Condição
     * @param tabelas Nome das tabelas
     */
    public function insert($campos = "*", $valores = "", $tabelas = ""){
		$SQL_valores = '';
		
		foreach ($valores as $rows ){	
			if(($rows == "NULL") ||(strstr($rows,"to_date('")))
				$SQL_valores .= " ".$rows.",";
			else 
				$SQL_valores .= " '".$rows."',";
		}//fim foreach	

		$SQL_valores = substr($SQL_valores, 0, strrpos($SQL_valores,","));	//Exclui a ultima virgula									
        
        $query = "insert into $tabela ($campos) values ($SQL_valores)";	
			
        $query = mysql_query($query, $this->BD_conexao);

        //Verifica se conseguiu realizar a query
        if($query === false)
            throw new Exception("<br/><br/>Não foi possível inserir no Banco Dados! <br/>Motivo: ".utf8_encode(mysql_error()));         

    }

    /** 
     * Metodo executa uma query 
     * @param Array campos campos  Nome dos campos,  por padrão "*" 
     * @param Array valores Condição
     * @param tabelas Nome das tabelas
     */
    public function update($campos = "*", $valores = "", $tabelas = ""){
        $SQL_campos = "";
        $cont = 0;
        
		//converte o array de campos recebido
        $array_campos = explode(",", $campos);
        
		//verifica a lista do array recebido
		foreach ($array_campos as $rows ){	
			if($cont){ $SQL_campos .= ", "; }						
			if(($valores["$cont"] == "NULL") ||(strstr($valores["$cont"],"to_date('"))){ $SQL_campos .= $rows." = ".$valores["$cont"]; }else{ $SQL_campos .= $rows." = '".$valores["$cont"]."'"; }
			$cont++;
		}//fim foreach		
	
		$update = "update $tabela set $SQL_campos where $condicao";

        $query = mysql_query($query, $this->BD_conexao);

        //Verifica se conseguiu realizar a query
        if($query === false)
            throw new Exception("<br/><br/>Não foi possível alterar no Banco Dados! <br/>Motivo: ".utf8_encode(mysql_error()));         
    }    

    /** 
     * Metodo executa uma query 
     * @param tabelas Nome das tabelas
     * @param where   Condição
     */
    public function delete($tabelas = "", $where = ""){
        if($where == "") throw new Exception("<br/><br/>Não foi possível deletar no Banco Dados! <br/>Motivo: Falta informar condição!");         

        $query  = " delete from $tabela";
        $query .= " where ".$where;


        $query = mysql_query($query, $this->BD_conexao);

        //Verifica se conseguiu realizar a query
        if($query === false)
            throw new Exception("<br/><br/>Não foi possível deletar no Banco Dados! <br/>Motivo: ".utf8_encode(mysql_error()));         
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
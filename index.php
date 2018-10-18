<?php
/**
 * Primeira página que é executada quando o sistema é carregado
 * 
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 03/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              Primeiro arquivo a ser executado quando o sistema carrega           
 * =================================================================
 * 
 * Dir  - ~Raiz~
 * File - index.php
 */

 // PHP mostra os erros na tela
 ini_set('display_errors', 1);
 
 //Inicia as seçoes
 session_start();

 /**
  * Importa a classe que gerencia os controlles; 
  */
  require_once 'lib/ControllerMaster.php';
  
  /**
   *  Executa o Gerenciador dos Controlles, para redirecionar para a página correta
   */
  try{

    //Caso o usuário recarregue a página, Redireciona para o Controller Home e Action listar
    
    if(isset($_SESSION['usuario']) && $_REQUEST['controller'] != 'Home' && $_REQUEST['controller'] != 'Login'){
      ControllerMaster::setRequest('Home', 'listar'); 
    }

    $controller = new ControllerMaster();
    $controller->loadController();
  }catch(Exception $e) { //Caso de algum erro, o Controller: HomeController e a Action: listarAction, serão carregadas
    ControllerMaster::setRequest('Home', 'listar'); 
    $controller->loadController();
  }
?>
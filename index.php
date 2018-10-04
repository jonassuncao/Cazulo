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


 /**
  * Importa a classe que gerencia os controlles; 
  * Executa o controler principal;
  * O controller principal vai carregar as variaveis da requisição;
  * Essa página index.php não tem vaiaveis de requisição;
  * O controllerMaster vai chamar o controller de Login
  *
  */
  require_once 'lib/ControllerMaster.php';
  $controller = new ControllerMaster();
  $controller->loadController();

?>
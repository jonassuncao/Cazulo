<?php
/**
 * Essa é a página principal do sistema, todo o MVC vai acontecer nesse arqui
 * Esse arquivo vai pegar a requisição e encaminhar para a Rota que foi solicitada
 * 
 * 
 * @author Jonathas Assunção
 * @version 0.0.2
 * 
 ** =================================================================
 * date - 23/11/2018 - @version 0.0.2
 * description: Alteração no processamento das informações
 *              1o Verifica se o usuário está logado,
 *              2o Verifica se a rota solicitada existe
 *              3o Verifica se o usuário tem permissão para acessar a rota
 *              4o Encaminha a requisição para a rota solicitada
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
 //ini_set('display_errors', 1);
 error_reporting(0);
 ini_set('display_errors', FALSE);
 
 //Inicia as seçoes
 session_start();

  //Importa as classes do Roteador, Renderizar Página HTML e do Login
  require_once 'lib/Roteador.php';
  require_once 'Models/LoginModel.php';
  
  /**
   *  Realiza algumas validações antes de encaminhar para a rota requisitada
   */
  try{
    
    //Instancia as classes para a realização das validações e encaminhamento das rotas
    $usuario = new LoginModel(); //Classe responsável por verificar se o usuário está logado e se possui acesso
    $rota = new Roteador();      //Classe responsável por validar e encaminhas as rotas
    //=======================================================
    
    /*=========== O usuário está logado? ==================*/
    if($usuario->temUsuarioLogado()){
      //Está logado       
    }else{
      //usuário não está logado, verifica se quer logar...
      /*=========== O usuário quer logar? ==================*/
      $rota->baixarRotasRequisicao(); //Pega a rota solicitada na requisição
      if($rota->getRotas() == 'Login.login' ){
          //Usuário quer logar
      }else{
        //Não está logado e nem quer logar
        $rota->definirRotas('Login.exibir'); //Redireciona a rota para a página de Login                
      }
      //=======================================================
    }
    //=======================================================
    
    /*=========== A rota solicitada existe? ==================*/
    $rota->baixarRotasRequisicao(); //Pega a rota solicitada na requisição
    
    if($rota->rotaExiste()){
      //Rota existe
    }else{
      //Rota não existe      
      throw new Exception("Rota solicitada não existe..."); //Rota não existe, gera uma exceção
    }
    //=======================================================


    /*============== O usuário tem permissão pra acessar essa rota? =======================*/
    //Passa a rota como parametro e verifica se o usuário tem permissão
    if($usuario->temPermissao($rota->getRotas())){ 
      //Tem permissão!      
    }else{ 
      //Não tem permissão        
        throw new Exception($usuario->getMensagem()); //Usuário não tem permissão, gera exeção
    }
    //=======================================================================================


    
    /*============== Encaminha a requisição para a rota solicitada =======================*/    
    $rota->executarRota();    
    //======================================================================================
    
  }catch(Exception $e) {     
    //Monta uma página HTML com o erro
    $view = new Views('Views/Sistema/admin/modalErroView.phtml', Array("header"=> "Erro ao carregar rota: ".$rota->getRotas(),"body"=> "Motivo: ".$e->getMessage()."<br/>Entre em contato com o suporte."));
    $view->imprimirHTML();
  }
?>
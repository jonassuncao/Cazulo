<?php
/**
 * Controlador da página Home
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 05/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              criação do método listarAction que 
 *              exibe a tela de adminitrador do sistema e adiciona um Controller
 *              para cada opção      
 * =================================================================
 * 
 * Dir  - Controllers
 * File - HomeController.php
 */ 

 
 //Inclui a classe model de negócio
 require_once 'Models/HomeModel.php';

 class HomeController{

    /**
     * Exibe a tela de login
     * 
     */
    public function listarAction(){
        $usuario = new HomeModel($_SESSION['usuario']);

        //Define os parametros a serem enviados para a página HTML

        //Renderiza a página de Login
        $view = new ViewMaster('Views/Sistema/admin/fundoView.phtml', Array("user"=>$usuario->toValores()));
        //Retorna para o navegador a página HTML à ser exibida.
        $view->showHTMLPag();
        
    }

    public function prestacaoContasAction(){
        
    }

    public function previsaoDespesasAction(){
        
    }

    public function taxaCondominioAction(){
        
    }

    public function controleAdimplenciaAction(){
        
    }

    public function condominioAction(){
        
    }

    public function condominoAction(){
        
    }

    public function categoriaAction(){
        
    }

    public function usuarioAction(){
        
    }
 }
?>
<?php
/**
 * Controlador do controle de Adimplencia/Inadimplencia
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 02/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              criação do método listar que 
 *              exibe a página HTML no navegador referente ao controle de Adimplencia/Inadimplencia
 * =================================================================
 * 
 * Dir  - Controllers
 * File - ControleAdimplenciaController.php
 */
 
 //Inclui a classe model de negócio
 require_once 'Models/ControleAdimplenciaModel.php';

 class ControleAdimplenciaController{

    /**
     * Exibe a tela de Categoria
     * 
     */
    public function listarAction(){
        //Renderiza a página de Login
        $view = new ViewMaster('Views/Sistema/admin/ControleAdimplenciaView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->showHTMLPag();
        
    }
    
 }
?>
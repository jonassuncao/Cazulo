<?php
/**
 * Controlador das Unidades (Condôminos)
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 02/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              criação do método listar que 
 *              exibe a página HTML no navegador referente as Unidades (Condôminos)
 * =================================================================
 * 
 * Dir  - Controllers
 * File - UnidadesController.php
 */
 
 //Inclui a classe model de negócio
 require_once 'Models/UnidadesModel.php';

 class UnidadesController{

    /**
     * Exibe a tela de Categoria
     * 
     */
    public function listarAction(){
        //Renderiza a página de Login
        $view = new ViewMaster('Views/Sistema/admin/UnidadesView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->showHTMLPag();
        
    }
    
 }
?>
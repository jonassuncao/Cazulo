<?php
/**
 * Controlador da Catagoria
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 02/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              criação do método listar que 
 *              exibe a página HTML no navegador referente a Categoria
 * =================================================================
 * 
 * Dir  - Controllers
 * File - CategoriaController.php
 */
 
 //Inclui a classe model de negócio
 require_once 'Models/CategoriaModel.php';

 class CategoriaController{

    /**
     * Exibe a tela de Categoria
     * 
     */
    public function listarAction(){
        //Renderiza a página de Login
        $view = new ViewMaster('Views/Sistema/admin/categoriasView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->showHTMLPag();
        
    }
    
 }
?>
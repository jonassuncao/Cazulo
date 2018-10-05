<?php
/**
 * Controlador da Taxa de Condominio
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 02/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              criação do método listar que 
 *              exibe a página HTML no navegador referente a Taxa de Condominio
 * =================================================================
 * 
 * Dir  - Controllers
 * File - TaxaCondominioController.php
 */
 
 //Inclui a classe model de negócio
 require_once 'Models/TaxaCondominioModel.php';

 class TaxaCondominioController{

    /**
     * Exibe a tela de Categoria
     * 
     */
    public function listarAction(){
        //Renderiza a página de Login
        $view = new ViewMaster('Views/Sistema/admin/TaxaCondominioView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->showHTMLPag();
        
    }
    
 }
?>
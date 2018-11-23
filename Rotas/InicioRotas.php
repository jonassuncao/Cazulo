<?php
/**
 * Controlador da tela inicio (Home Page)
 * 
 * @author Jonathas Assunção
 * @version 0.0.2
 * 
 * =================================================================
 * date - 23/11/2018 - @version 0.0.2
 * description: Muda chamada da view
 * =================================================================
 * date - 02/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              criação do método listar que 
 *              exibe a página HTML no navegador referente a tela inicio (Home Page)
 * =================================================================
 * 
 * Dir  - Rotas
 * File - InicioRotas.php
 */
 
 //Inclui a classe model de negócio
 require_once 'Models/InicioModel.php';

 class InicioRotas{

    /**
     * Exibe a tela de Categoria
     * 
     */
    public function listarAction(){
        //Renderiza a página de Login
        $view = new Views('Views/Sistema/admin/InicioView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->imprimirHTML();
        
    }
    
 }
?>
<?php
/**
 * Controlador da Catagoria
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
 *              exibe a página HTML no navegador referente a Categoria
 * =================================================================
 * 
 * Dir  - Rotas
 * File - CategoriaRotas.php
 */
 
 //Inclui a classe model de negócio
 require_once 'Models/CategoriaModel.php';

 class CategoriaRotas{

    /**
     * Exibe a tela de Categoria
     * 
     */
    public function listarAction(){
        //Renderiza a página de Login
        $view = new Views('Views/Sistema/admin/categoriasView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->imprimirHTML();
        
    }
    
 }
?>
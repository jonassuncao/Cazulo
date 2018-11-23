<?php
/**
 * Controlador do Condominos
 * 
 * @author Jonathas Assunção
 * @version 0.0.2
  * =================================================================
 * date - 23/11/2018 - @version 0.0.2
 * description: Muda chamada da view
 * =================================================================
 * date - 19/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              criação do método listar que 
 *              exibe a página HTML no navegador referente ao condomino
 * =================================================================
 * 
 * Dir  - Rotas
 * File - CondominosRotas.php
 */
 
 //Inclui a classe model de negócio
 require_once 'Models/CondominosModel.php';

 class CondominosRotas{

    /**
     * Exibe a tela de Condomino
     * 
     */
    public function listarAction(){
        //Renderiza a página de Listar Condominios
        $view = new Views('Views/Sistema/admin/ListarCondominosView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->imprimirHTML();
        
    }

    /**
     * Exibe a tela de Editar condomino
     * 
     */
    public function condominoAction(){
        //Renderiza a página de Selecionar Condominios
        $view = new Views('Views/Sistema/admin/CondominosView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->imprimirHTML();
        
    }  
        
 }
?>
<?php
/**
 * Controlador da Prestação de Contas
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 02/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              criação do método listar que 
 *              exibe a página HTML no navegador referente a Prestação de Contas
 * =================================================================
 * 
 * Dir  - Controllers
 * File - PrestacaoContasController.php
 */
 
 //Inclui a classe model de negócio
 require_once 'Models/PrestacaoContasModel.php';
 require_once 'Models/ExtratoModel.php';

 class PrestacaoContasController{

    /**
     * Exibe a tela de Prestação de Contas
     * 
     */
    public function listarAction(){
        //Renderiza a página 
        $view = new ViewMaster('Views/Sistema/admin/PrestacaoContasView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->showHTMLPag();
        
    }
  
    /**
     * Verifica e exibe a tela de opção: Prestação de Contas, Documentos, RDEF e RREF
     * 
     */
    public function listarOPCAction(){
        $tela = $_POST['tela']; // Pega qual é a opção selecionada

        switch ($tela) {
            case 'pc': //Exibir o Resumo da Prestação de Contas
                //Renderiza a página 
                $view = new ViewMaster('Views/Sistema/admin/prestacaoContasPCView.phtml');
                break;

            case 'doc': //Exibir o Resumo dos Documentos
                //Renderiza a página 
                $view = new ViewMaster('Views/Sistema/admin/prestacaoContasDocumentosView.phtml');
                break;                

            case 'ext': //Exibir Extrato
                //Renderiza a página 
                $view = new ViewMaster('Views/Sistema/admin/prestacaoContasExtratoMenuView.phtml');
                break;
            
            case 'rdef': //Exibir o Resumo do Reconhecimento das Despesas de Exercícios Futuros
                //Renderiza a página 
                $view = new ViewMaster('Views/Sistema/admin/prestacaoContasRDEFView.phtml');
                break;
            
            case 'rref': //Exibir o Resumo do Reconhecimento das Receitas de Exercícios Futuros
                //Renderiza a página 
                $view = new ViewMaster('Views/Sistema/admin/prestacaoContasRREFView.phtml');
                break; 

            default: // Opção inválida exibe erro
                //Renderiza a página 
                $view = new ViewMaster('Views/Sistema/admin/modalErroView.phtml', Array("header"=> "Erro ao carregar opção: ".$tela,"body"=> "Motivo: Opção inválida ou não existe! <br/>Entre em contato com o suporte."));
                break;            
        }
        
        //Retorna para o navegador a página HTML à ser exibida.                
        $view->showHTMLPag();
        
    }    

    /**
     * Lista os dados do extrato selecionado
     * 
     */
    public function listarEXTAction(){
        $banco    = $_POST['banco']; // Pega o nome do Banco
        $agencia  = $_POST['ag'];    // Pega número da Agencia
        $operacao = $_POST['op'];    // Pega número da Operação
        $conta    = $_POST['conta']; // Pega número da Conta
        $extrato  = isset($_FILES['ext'])? $_FILES['ext']: null;   // Pega o arquivo do extrato
        //Renderiza a página 
        
        $header = Array("Banco-img"=> "bradesco",
                        "Banco"=> "-",
                        "qCliente"=> "-",
                        "Conta"=> "- / - / -",
                        "Data"=> "- ",
                        "Periodo"=> "-/-");                        
                        
                        
        //Carrega dados do header do array
        if($extrato != null){
            $obj = new ExtratoModel($extrato);
            $header = $obj->getHeader();            
        }

        $view = new ViewMaster('Views/Sistema/admin/prestacaoContasExtratoOpcaoView.phtml', Array("header"=> $header));
        //Retorna para o navegador a página HTML à ser exibida.                
        $view->showHTMLPag();
        
    }    
    
    
    
 }
?>
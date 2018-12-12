<?php
/**
 * Controlador da Prestação de Contas
 * 
 * @author Jônathas Assunção
 * @version 0.0.3
 *
 * =================================================================
 * date - 09/12/2018 - @version 0.0.3
 * description: Muda chamada da view, tem que passar o code_http resposta
 *              Nome da Views, não precisa mais do caminho absoluto
 * =================================================================
 * date - 23/11/2018 - @version 0.0.2
 * description: Muda chamada da view
 * =================================================================
 * date - 02/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              criação do método listar que 
 *              exibe a página HTML no navegador referente a Prestação de Contas
 * =================================================================
 * 
 * Dir  - Rotas
 * File - PrestacaoContasRotas.php
 */
 
 //Inclui a classe model de negócio
 require_once 'Models/PrestacaoContasModel.php';
 require_once 'Models/ExtratoModel.php';

 class PrestacaoContasRotas{

    /**
     * Exibe a tela de Prestação de Contas
     * 
     */
    public function listarAction(){
        //Renderiza a página 
        $view = new Views(200,'Sistema/Admin/prestacaoContasView');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->imprimirHTML();
        
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
                $view = new Views(200,'Sistema/Admin/prestacaoContasPCView');
                break;

            case 'doc': //Exibir o Resumo dos Documentos
                //Renderiza a página 
                $view = new Views(200,'Sistema/Admin/prestacaoContasDocumentosView');
                break;                

            case 'ext': //Exibir Extrato
                //Renderiza a página 
                $view = new Views(200,'Sistema/Admin/prestacaoContasExtratoMenuView');
                break;
            
            case 'rdef': //Exibir o Resumo do Reconhecimento das Despesas de Exercícios Futuros
                //Renderiza a página 
                $view = new Views(200,'Sistema/Admin/prestacaoContasRDEFView');
                break;
            
            case 'rref': //Exibir o Resumo do Reconhecimento das Receitas de Exercícios Futuros
                //Renderiza a página 
                $view = new Views(200,'Sistema/Admin/prestacaoContasRREFView');
                break; 

            default: // Opção inválida exibe erro
                //Renderiza a página 
                $view = new Views(200,'Sistema/Admin/modalErroView', Array("header"=> "Erro ao carregar opção: ".$tela,"body"=> "Motivo: Opção inválida ou não existe! <br/>Entre em contato com o suporte."));
                break;            
        }
        
        //Retorna para o navegador a página HTML à ser exibida.                
        $view->imprimirHTML();
        
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
        
        
        //Inicializa as variaveis de retorno
        $header = Array("Cliente"=> "-",
                        "Conta"=> "- / - / -",
                        "Data"=> "- ",
                        "Periodo"=> "-/-");                        
        $lancamento = Array();                
        $saldo = Array("Inicial"=> "-",
                       "Final"=> "-");  
                        
        //Caso tenha enviado o arquivo para o servidor, carrega o arquivo e preenche os dados.
        if($extrato != null){
            $obj        = new ExtratoModel($extrato);
            $header     = $obj->getHeader();  
            $lancamento = $obj->getExtrato();  
            $saldo      = $obj->getSaldo(); 
        }
        
        $header["Banco-img"] = "bradesco";          
        $header["Banco"]     = "Bradesco";

        //Renderiza a página 
        $view = new Views(200,'Sistema/Admin/prestacaoContasExtratoOpcaoView', Array("header"=> $header, "extrato"=> $lancamento, "saldo"=> $saldo));
        //Retorna para o navegador a página HTML à ser exibida.                
        $view->imprimirHTML();
        
    }    
    
    
    
 }
?>
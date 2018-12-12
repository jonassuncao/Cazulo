<?php
/**
 * Controlador do Login
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
 *              criação do método logarAction que 
 *              autentica o usuário e redireciona para o HomeController (Página Home do sistema);
 * =================================================================
 * 
 * Dir  - Rotas
 * File - LoginRotas.php
 */
 
 //Inclui a classe model de negócio
 require_once 'Models/LoginModel.php';

 class LoginRotas{

    /**
     * Exibe a tela de login
     * 
     */
    public function exibirAction(){
        //Renderiza a página de Login
        $view = new Views(200,'Login/loginView');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->imprimirHTML();
        
    }

    public function loginAction(){
        
        //Instancia a classe Model dos Contatos
        $usuario = new LoginModel();

        //Captura as variaveis de login e passa para o Model Tratar
        $usuario->setUsuario($_POST['usuario']);
        $usuario->setSenha($_POST['senha']);
        $usuario->setCaptcha($_POST['g-recaptcha-response']);

        //Tenta autenticar o usuário
        if($usuario->autenticaUsuario()){ //Tenta
              //Usuário autenticado com sucesso
              
              //Redireciona para próxima página
              echo $usuario->getMensagem(); 
              
              //O usuário está autenticado... Usa o roteador para encaminhar a requisição para o Home.Listar
              Roteador::definirRotas('Home.listar'); //Redireciona a rota para a página de principal do sistema
              Roteador::recarregarClient();          //Redireciona para a página Home

        }else{ //Não está autenticado
            //Pega a mensagem de Erro e Executa o exibirAction            
            echo $usuario->getMensagem(); //Retorna a mensagem de erro
        }
        
    }


    /**
     * Desloga do sistema e exclui as seções
     * 
     */
    public function logoffAction(){        
        LoginModel::sair();            
    }        
    
 }
?>
<?php
/**
 * Controlador da página Home
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
 * date - 05/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              criação do método listarAction que 
 *              exibe a tela de adminitrador do sistema e adiciona um Controller
 *              para cada opção      
 * =================================================================
 * 
 * Dir  - Rotas
 * File - HomeRotas.php
 */ 

 
 //Inclui a classe model de negócio
 require_once 'Models/HomeModel.php';

 class HomeRotas{

    /**
     * Exibe a tela de login
     * 
     */
    public function listarAction(){
        $usuario    = new HomeModel(Roteador::baixarParametro('usuario'));
        $condominio = Roteador::baixarParametro('cond');
        $rota       = Roteador::getRota();
        
        //Define os parametros a serem enviados para a página HTML

        //Renderiza a página de Login
        $view = new Views(200,'Sistema/Admin/fundoView', Array("user"=>$usuario->toValores(), "cond"=>$condominio, 'rota'=>$rota));
        //Retorna para o navegador a página HTML à ser exibida.
        $view->imprimirHTML();
        
    }

    public function exibirAction(){ 
        $descricaoOpcao        = Roteador::baixarParametro('titulo');

        $login = new LoginModel(); //Instancia uma classe Login

        //Verifica se o usuário que está logado tem permissão para acessar o controller e Action solicitado
        if($login->isPermissao($controllerSolicitado, $actionSolicitado)){ 
            /**Se entrou no IF, é porque tem a permissão... 
             * Agora modifica os parametros da Requisição e tenta importar o controller, e chamar a função Action solicitada
            */
            ControllerMaster::setRequest($controllerSolicitado, $actionSolicitado);  
            try{
                $controller = new ControllerMaster(); //Instancia o Gerenciador de Controllers
                $controller->loadController(); //Tenta importar o Controller e executar o action solicitado
            }catch(Exception $e) { //Caso dê algum erro, exibe um Modal Erro para o usuário e informa a mensagem de erro
                $view = new Views(200,'Sistema/Admin/modalErroView', Array("header"=> "Erro ao carregar página: ".$descricaoOpcao,"body"=> "Motivo: ".$e->getMessage()."<br/>Entre em contato com o suporte."));
                $view->imprimirHTML();
            }
        }else{ 
            /**
             * Se Entrou no ELSE, então o usuário não tem permissão para acessar esse controller e Action
             * Exibe um Modar de Atenção, informando a mensagem retornada pela Class LoginModel()
             */
            $view = new Views(200,'Sistema/Admin/modalAtencaoView', Array("header"=> "A página ".$descricaoOpcao." não pode ser carregada","body"=> "Motivo: ".$login->getMensagem()));
            $view->imprimirHTML();
        }
    }
 }
?>
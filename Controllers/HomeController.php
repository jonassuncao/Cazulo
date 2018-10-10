<?php
/**
 * Controlador da página Home
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 05/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              criação do método listarAction que 
 *              exibe a tela de adminitrador do sistema e adiciona um Controller
 *              para cada opção      
 * =================================================================
 * 
 * Dir  - Controllers
 * File - HomeController.php
 */ 

 
 //Inclui a classe model de negócio
 require_once 'Models/HomeModel.php';

 class HomeController{

    /**
     * Exibe a tela de login
     * 
     */
    public function listarAction(){
        $usuario = new HomeModel($_SESSION['usuario']);

        $path = "Views/Sistema/admin/";
        $diretorio = dir($path);
        $pag = array();
        while($arquivo = $diretorio -> read()){
            if(!(strpos($arquivo, '.html') === false))
                array_push($pag, str_replace("View.html", "", $arquivo));
        }
        $diretorio -> close();   
        //echo var_dump($pag);
        //Define os parametros a serem enviados para a página HTML

        //Renderiza a página de Login
        $view = new ViewMaster('Views/Sistema/admin/fundoView.phtml', Array("user"=>$usuario->toValores(), "pag"=>$pag));
        //Retorna para o navegador a página HTML à ser exibida.
        $view->showHTMLPag();
        
    }

    public function exibirAction(){ 
        $controllerSolicitado  = $_POST['opc'];
        $descricaoOpcao        = $_POST['desc'];

        $login = new LoginModel(); //Instancia uma classe Login

        //Verifica se o usuário que está logado tem permissão para acessar o controller e Action solicitado
        if($login->isPermissao($controllerSolicitado, 'listar')){ 
            /**Se entrou no IF, é porque tem a permissão... 
             * Agora modifica os parametros da Requisição e tenta importar o controller, e chamar a função Action solicitada
            */
            //ControllerMaster::setRequest($controllerSolicitado, 'listar');  
            try{
                $view = new ViewMaster('Views/Sistema/admin/'.$controllerSolicitado.'View.html');
                $view->showHTMLPag();
              //  $controller = new ControllerMaster(); //Instancia o Gerenciador de Controllers
               // $controller->loadController(); //Tenta importar o Controller e executar o action solicitado
            }catch(Exception $e) { //Caso dê algum erro, exibe um Modal Erro para o usuário e informa a mensagem de erro
                $view = new ViewMaster('Views/Sistema/admin/modalErroView.html', Array("header"=> "Erro ao carregar página: ".$descricaoOpcao,"body"=> "Motivo: ".$e->getMessage()."<br/>Entre em contato com o suporte."));
                $view->showHTMLPag();
            }
        }else{ 
            /**
             * Se Entrou no ELSE, então o usuário não tem permissão para acessar esse controller e Action
             * Exibe um Modar de Atenção, informando a mensagem retornada pela Class LoginModel()
             */
            $view = new ViewMaster('Views/Sistema/admin/modalAtencaoView.html', Array("header"=> "A página ".$descricaoOpcao." não pode ser carregada","body"=> "Motivo: ".$login->getMensagem()));
            $view->showHTMLPag();
        }
    }
 }
?>
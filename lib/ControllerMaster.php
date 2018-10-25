<?php
/**
 * Classe responsável por pegar as variaveis passadas na requisição
 * e verificar qual controlador está sendo solicitado,
 * verifica se o controlador solicitado é valido e executa-o
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 03/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              Recupera da requisição qual é o controlador requisitado,
 *              Valida o controlador e executa o controlador
 * =================================================================
 * 
 * Dir  - lib
 * File - ControllerMaster.php
 */

/**
* Essa função garante que todas as classes 
* da pasta lib serão carregadas automaticamente
*  //A pasta lib contém todas as classes genéricas que serão usadas no projeto
*/
spl_autoload_register(function($st_class){
    if(file_exists('lib/'.$st_class.'.php'))
        require_once 'lib/'.$st_class.'.php';
});

//Essa biblioteca será usada para verificar se o usuário possui permissão
//para acessar o controller/Action
require_once 'Models/LoginModel.php';

class ControllerMaster{

    protected $controller; //Armazena o nome do controller requisitado
    protected $action;     //Armazena a acao requisitada para o controller

    /**
     * Captura qual controller e qual action deverá ser carregado e executado
     * Caso não haja controller o padrão será o LoginController
     * Caso não haja action o padrão será o exibirAction
     * 
     * Primeiro vai tentar capturar as váriaveis do REQUEST,
     * Caso não haja nada no REQUEST, tenta capturar os parametros na SESSION,
     * Caso não haja nada na SESSION, usa valores default: controller = Login, action = exibir
     */
    private function getRequest(){
         
        //Captura valores para o Controller
        if(isset($_REQUEST['controller']))          $this->controller = $_REQUEST['controller'];     
        else if(isset($_SESSION['controller']))     $this->controller = $_SESSION['controller'];     
        else                                        $this->controller = 'Login';
                
        //Captura valores para o Action
        if(isset($_REQUEST['action']))              $this->action = $_REQUEST['action'];     
        else if(isset($_SESSION['action']))         $this->action = $_SESSION['action'];     
        else                                        $this->action = 'exibir';          
    }

    /**
     * Modifica os valores do Request
     * Essa função é utilizada para modificar o controler;
     */
    static function setRequest($controller = 'Login', $action = 'exibir'){
        //Salva os valores no REQUEST
        $_REQUEST['controller'] = $controller;
        $_REQUEST['action']     = $action;

        //Salva o REQUEST na seção, caso de refresh na página os valores do Controller e Action não são perdidos
        $_SESSION['controller'] = $_REQUEST['controller'];
        $_SESSION['action']     = $_REQUEST['action'];
    }

    /**
     * Carrega o controle e a acao solicitada,
     * Verifica se controle e acao existe,
     *  Importa  o controller;
     *  Instancia a classe do controller;
     *  Executa o método do Controller;
     * @throws Exception
     */
    public function loadController(){
        $this->getRequest(); //Captura qual o controller e o action a ser carregado        
        /**
         * Verifica se o arquivo do controlador existe
         * 
         * Case TRUE: Importa o arquivo para o projeto
         * Case FALSE: Gera exceção - Arquivo não encontrado
         */
        $controller_file = 'Controllers/'.$this->controller.'Controller.php';        

        if(file_exists($controller_file)) require_once $controller_file; 
        else throw new Exception("'".$controller_file."' não é um arquivo controlador válido!");

        /**
         * Verifica se a classe existe
         * 
         * Case TRUE: Instancia a classe para o projeto
         * Case FALSE: Gera exceção - Classe não encontrado
         */
        $controller_class = $this->controller.'Controller';        

        if(class_exists($controller_class)) $controller_class = new $controller_class;
        else throw new Exception("'".$this->controller."' não é uma classe do controlador '".$controller_file."' válido!");

        /**
         * Verifica se o metodo existe
         * 
         * Case TRUE: Executa o método da classe Controller que foi importada
         * Case FALSE: Gera exceção - Método não encontrado
         */        
        $controller_method = $this->action.'Action';        
        if(method_exists($controller_class, $controller_method)) $controller_class->$controller_method();
        else throw new Exception("'".$controller_method."' não é um método válido para classe '".$this->controller."' no controlador '".$controller_file."'");
    }


    /**
     * Redireciona a página para a URL solicitada
     */
    public static function redirect(){                                
        echo "<script>window.location.reload();</script>";                                
    }
}


?>
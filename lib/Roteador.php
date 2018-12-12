<?php
/**
 * Classe responsável por pegar as variaveis passadas na requisição
 * e verificar qual controlador está sendo solicitado,
 * verifica se o controlador solicitado é valido e executa-o
 * 
 * @author Jonathas Assunção
 * @version 0.0.2
 *
 * * =================================================================
 * date - 23/11/2018 - @version 0.0.2
 * description: Alteração no nome do arquivo, 
 *              Alteração no nome das funções,
 *              Alteração no nome dos parametros da requisição de: 'controller' e 'action' para: 'rota' e 'acao',
 *              Alterado o modificador do pegaRotas(), de private para public
 *              Criado método que verifica se a Rota existe
 * =================================================================
 * date - 03/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              Recupera da requisição qual é o controlador requisitado,
 *              Valida o controlador e executa o controlador
 * =================================================================
 * 
 * Dir  - lib
 * File - Roteador.php
 */

/**
* Essa função garante que todas as classes 
* da pasta lib serão carregadas automaticamente
*  //A pasta lib contém todas as classes genéricas que serão usadas no projeto
*/
spl_autoload_register(function($st_class){
    if(file_exists('Lib/'.$st_class.'.php'))
        require_once 'Lib/'.$st_class.'.php';
});
spl_autoload_register(function($st_class){
    if(file_exists('Lib/Exceptions/'.$st_class.'.php'))
        require_once 'Lib/Exceptions/'.$st_class.'.php';
});

class Roteador{

    protected $rota; //Armazena o nome do controller requisitado
    protected $acao;     //Armazena a acao requisitada para o controller

    /**
     * Captura qual controller e qual action deverá ser carregado e executado
     * Caso não haja controller o padrão será o LoginController
     * Caso não haja action o padrão será o exibirAction
     * 
     * Primeiro vai tentar capturar as váriaveis do REQUEST,
     * Caso não haja nada no REQUEST, tenta capturar os parametros na SESSION,
     * Caso não haja nada na SESSION, usa valores default: controller = Login, action = exibir
     */
    public function baixarRotasRequisicao(){
         
        //Captura valores para o Controller
        if(isset($_REQUEST['rota']))      $this->rota = $_REQUEST['rota'];     
        else if(isset($_SESSION['rota'])) $this->rota = $_SESSION['rota'];     
        else                              $this->rota = 'Login';
                
        //Captura valores para o Action
        if(isset($_REQUEST['acao']))      $this->acao = $_REQUEST['acao'];     
        else if(isset($_SESSION['acao'])) $this->acao = $_SESSION['acao'];     
        else                              $this->acao = 'exibir';          
    }

    /**
     *  Retorna a rota solicitada
     */
    public function getRotas(){         
        return $this->rota.'.'.$this->acao;
    }

    /**
     * Baixa um parâmetro passado na requisição     
     * @param $param string -- Passa o parametro a ser baixado na requisição
     */
    public static function baixarParametro($param){
         
        //Captura valores para o Controller
        if(isset($_REQUEST[$param]))      return $_REQUEST[$param];     
        else if(isset($_SESSION[$param])) return $_SESSION[$param];     
        else                              return null;
    }

    /**
     * Adiciona uma rota na Seção    
     * @param $rota string -- Passa o parametro a ser baixado na requisição
     */
    public static function atualizaSubRota($rota = null){
         
        //Captura valores para o Controller        
        $_SESSION['rotaAtual'] = $rota;
    }

    /**
     * Retorna a rota da seção
     * @param $rota string -- Passa o parametro a ser baixado na requisição
     */
    public static function getRota(){
                    
        return ($_SESSION['rotaAtual'] != null)? $_SESSION['rotaAtual'] : "Inicio.listar";
    }

    /**
     * Baixa um parâmetro passado na requisição     
     * @param $param string -- Passa o parametro a ser adicionado na requisição
     */
    public static function adicionaParametro($param = null){
         
        //Se passar os parâmetros, armazena na REQUEST e SESSION
        if($param != null){
            $param = explode("&",$param);
            foreach ($param as $valor) {
                $indice = substr($valor, 0, strpos($valor,'='));
                $_REQUEST[$indice] = substr($valor, strpos($valor,'=')+1);
                $_SESSION[$indice] = $_REQUEST[$indice];
            }
        }     
    }

    /**
     * Modifica os valores do Request
     * Essa função é utilizada para modificar o controler;
     */
    public static function definirRotas($rota = 'Login.exibir'){
        //Salva a rota no REQUEST
        if($rota == null){
            $_REQUEST['rota'] = null;
            $_REQUEST['acao'] = null;
        }else{
            $_REQUEST['rota'] = substr($rota, 0, strpos($rota,'.'));
            $_REQUEST['acao'] = substr($rota, strpos($rota,'.')+1);
        }
  
      
        //Salva o REQUEST na seção, caso de refresh na página os valores do Controller e Action não são perdidos
        $_SESSION['rota'] = $_REQUEST['rota'];
        $_SESSION['acao'] = $_REQUEST['acao'];


    }

    /**
     * Carrega o controle e a acao solicitada,
     * Verifica se controle e acao existe,
     *  Importa  a rota;
     *  Instancia a classe da rota;
     *  Executa o método da rota;
     * @throws Exception
     */
    public function executarRota($rota = null){
        
        //Rota não informada
        if($this->rota == "" || $this->acao == "")
            throw new Exception("Não foi passado para o Roteador, qual a rota requisitada!");
            
                
        /**
         * Verifica se o arquivo da rota existe
         * 
         * Case TRUE: Importa o arquivo para o projeto
         * Case FALSE: Gera exceção - Arquivo não encontrado
         */
        $rota_file = 'Rotas/'.$this->rota.'Rotas.php';        

        if(file_exists($rota_file)) require_once $rota_file; 
        else throw new Exception("'".$rota_file."' não é um arquivo roteador válido!");
        
        /**
         * Verifica se a classe existe
         * 
         * Case TRUE: Instancia a classe para o projeto
         * Case FALSE: Gera exceção - Classe não encontrado
         */
        $rota_class = $this->rota.'Rotas';        

        if(class_exists($rota_class)) $rota_class = new $rota_class;
        else throw new Exception("'".$this->rota."' não é uma classe do roteador '".$rota_file."' válido!");
        
        /**
         * Verifica se o metodo existe
         * 
         * Case TRUE: Executa o método da classe Controller que foi importada
         * Case FALSE: Gera exceção - Método não encontrado
         */        
        $rota_method = $this->acao.'Action';                
        
        if(method_exists($rota_class, $rota_method)) $rota_class->$rota_method();
        else throw new Exception("'".$rota_method."' não é um método válido para o roteador '".$this->rota."' na rota '".$rota_file."'");        
    }


    /**
     * Carrega o controle e a acao solicitada,
     * Verifica se controle e acao existe,
     *  Importa  o controller;
     *  Instancia a classe do controller;
     *  Executa o método do Controller;
     * @return boolean // TRUE - Rota existe | FALSE - Rota não existe
     */
    public function rotaExiste(){
        
        //Rota não informada
        if($this->rota == "" || $this->acao == "") return false;
        
        /**
         * Verifica se o arquivo da rota existe
         */
        $rota_file = 'Rotas/'.$this->rota.'Rotas.php';        
        
        if(file_exists($rota_file)){            
            require_once $rota_file; //Importa o arquivo            
        } else return false; //Arquivo não existe
        

        /**
         * Verifica se a classe existe
         */
        $rota_class = $this->rota.'Rotas';        
        
        if(class_exists($rota_class)){
            $rota_class = new $rota_class;
        } else return false; // Classe não existe
        
     
        /**
         * Verifica se o metodo existe
         */        
        $rota_method = $this->acao.'Action';        
        if(!method_exists($rota_class, $rota_method)) return false;        

        return true; //Rota existe
    }

    /**
     * Redireciona a página para a URL solicitada
     */
    public static function recarregarClient(){                                
        echo "<script>window.location.reload();</script>";
    }
}


?>
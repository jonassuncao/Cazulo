<?php
/**
 * Gerencia os dados dos Logins
 * 
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 02/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              Gerencia os dados dos Logins
 * =================================================================
 * 
 * Dir  - models
 * File - LoginModel.php
 */

class LoginModel{
    private $usuario;
    private $senha;
    private $captha;
    private $mensagem;

    function __construct(){
        $this->mensagem = "";
    }

    /**
     * Get's e Set's da classe 
     */
     public function setUsuario($usuario) { $this->usuario = $usuario; }
     public function setSenha($senha)     { $this->senha   = $senha;   }
     public function setCaptcha($captha)  { $this->captha  = $captha;  }

     public function getUsuario()  { return $this->usuario;  }
     public function getSenha()    { return $this->senha;    }
     public function getCaptcha()  { return $this->captha;   }
     public function getMensagem() { return $this->mensagem; }
    //=========================================================================

    /**
     * Verifica se o usuário pode ser autenticado
     */ 
    public function isAutenticado(){            
        if($this->usuario == "ADMIN"){ 
            //Se o usuário está autenticado
            //Cria duas seções: Armazenar o nome do usuário e a data que foi autenticado
            $_SESSION['usuario'] = $this->usuario;
            $_SESSION['data']   = date('Y-m-d H:i');
            
            return true;
        }else{
            $this->mensagem = "Usuário/Senha incorreto!";
            return false;    
        }
        
    }

    /**
     *  Verifica se o usuário tem permissão para essa página
     */
    public function isPermissao($controller, $action){
        //Caso esteja tentando acessar a página de login, o usuário tem permissão
        if($controller == 'Login' & $action == 'exibir') return true;

        //Verifica se a seção do usuário ainda é válido
        if(!isset($_SESSION['usuario'])){ $this->mensagem="Seção expirada... Logue novamente"; return false;} //Usuário não está logado

        //Verifica se a seção expirou
        //-------------------------
        
        //Consulta no Banco para verificar se usuário tem permissão para acessar o Controller/Action
        //----------------------------------
        
        return true;
    }

    /**
     *  Destroi a seção
     */
    public static function sair(){        
        //Limpa as variaveis de requisicao e Seção
        unset($_REQUEST);
        unset($_SESSION);        
        $_REQUEST = null;
        $_SESSION = null;
        session_destroy();
        ControllerMaster::setRequest(null, null);        

        //Redireciona para página inicial
        ControllerMaster::redirect(); 
    }
}

?>
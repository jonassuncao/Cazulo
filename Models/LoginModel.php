<?php
/**
 * Gerencia os dados dos Logins
 * 
 * 
 * @author Jonathas Assunção
 * @version 0.0.2
 ** =================================================================
 * date - 23/11/2018 - @version 0.0.2
 * description: Alterado as referências de 'controller' para 'rotas',
 *              Criado função que verifica se usuário está logado
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
    public function autenticaUsuario(){            
        if($this->usuario == "ADMIN"){ 
            //Se o usuário está autenticado
            //Cria duas seções: Armazenar o nome do usuário e a data que foi autenticado
            $_SESSION['usuario'] = $this->usuario;
            $_SESSION['data']   = date('Y-m-d H:i');
            $this->mensagem = "Logado com sucesso. <br/>Redirecionando...";
            return true;
        }else{
            $this->mensagem = "Usuário/Senha incorreto!";
            return false;    
        }
        
    }

    /**
     *  Verifica se o usuário tem permissão para a rota
     */
    public function temPermissao($rota){                
        return true;
    }
    
    /**
     * Verifica se tem algum usuário salvo na seção
     * @return boolean Caso TRUE (Usuário logado)|| Caso FALSE (Usuário não está logado)
     */
    public function temUsuarioLogado(){
         if(isset($_SESSION['usuario'])) return TRUE;
        
        return false;
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
        Roteador::definirRotas(null);    
        session_destroy();            

        //Redireciona para página inicial
        Roteador::recarregarClient(); 
    }
}

?>
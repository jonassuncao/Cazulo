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
        if($this->usuario == "ADMIN") return true;
        else{
            $this->mensagem = "Usuário/Senha incorreto!";
            return false;    
        }
        
    }

}

?>
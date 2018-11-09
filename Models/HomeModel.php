<?php
/**
 * Gerencia os dados do Home
 * 
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 02/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              Gerencia os dados dos Home
 *              Baixa o nome do usuário, permissão, login
 * =================================================================
 * 
 * Dir  - models
 * File - LoginModel.php
 */

class HomeModel{
    private $usuario;
    private $permissao;
    private $perfilAcesso;
    private $nome;
    private $imagem;

    function __construct($usuario){
        $this->usuario          = $usuario;        
        $this->perfilAcesso     = "Administrador";
        $this->nome             = "Jônathas Assunção";
        $this->imagem           = "Views\Sistema\admin\images\icons\\favicon.ico";
        $this->permissao        = Array("PrestacaoContas", 
                                        "PrevisaoDespesas", 
                                        "TaxaCondominio", 
                                        "ControleAdimplencia", 
                                        "Condominio",
                                        "Categoria",
                                        "Usuarios");
    }

    /**
     * Get's da classe 
     */
     public function getUsuario()       { return $this->usuario;      }
     public function getPermissao()     { return $this->permissao;    }
     public function getPerfilAcesso()  { return $this->perfilAcesso; }
     public function getNome()          { return $this->nome;         }
     public function getImagem()        { return $this->imagem;       }     
    //=========================================================================

    /**
     * Retorna os valores do usuário
     */ 
    public function toValores(){            
        return Array("usuario"=>        $this->getUsuario(),
                     "permissao"=>      $this->getPermissao(),
                     "perfilAcesso"=>   $this->getPerfilAcesso(),
                     "nome"=>           $this->getNome(),
                     "imagem"=>         $this->getImagem()        
                    );
    }
}

?>
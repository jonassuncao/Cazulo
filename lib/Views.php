<?php
/**
 * Renderiza os arquivos HTML
 * 
 * 
 * @author Jonathas Assunçào
 * @version 0.0.2
 * 
 *  * =================================================================
 * date - 23/10/2018 - @version 0.0.2
 * description: Alterado o nome da Função de 'showHTMLPag' para 'imprimirHTML',
 *              Alteração no nome da classe para 'Views'
 * =================================================================
 * date - 02/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              Renderiza o HTML a ser exibido,
 *              Passa os parametros para o HTML exibir as telas
 * =================================================================
 * 
 * Dir  - lib
 * File - Views.php
 */
class Views{

    /**
     * Armazena a página HTML
     * @var String
     */
    private $html_pag;

    /**
     * Armazena o nome do arquivo HTML
     * @var String
     */
    private $html_nome;

    /**
     * Armazena os valores a serem passados para o HTML
     * @var Array
     * 
     */
    private $html_valores;

    /**
     * Armazena o nome do arquivo HTML e os valores que serão enviados ao HTML
     * @param String $html_nome
     * @param Array $html_valores
     */
    function __construct($html_nome = null, $html_valores = null){
        if($html_nome != null) $this->setHTMLNome($html_nome);
        $this->html_valores = $html_valores;
    }

    /**
     * Armazena o nome do arquivo HTML a ser renderizado
     * @param string Nome da Pagina HTML a ser exibida
     * @throws Exception
     */
    public function setHTMLNome($html_nome){
        if(file_exists($html_nome)) $this->html_nome = $html_nome;
        else throw new Exception("View '$html_nome' não foi encontrada.");
    }

    /**
     * Retorna o nome da do arquivo HTML
     * @return string
     */
    public function getHTMLNome(){
        return $this->html_nome;
    }


    /**
     * Insere os valores à serem passados para a página HTML
     * @param Array valores para página HTML
     */
    public function setHTMLValores($html_valores){
        $this->html_valores = $html_valores;
    }

    /**
     * Retorna os valores que serão passados para a página HTML
     * @return Array valores para página HTML
     */
    public function getHTMLValores(){
        return $this->html_valores;
    }    

    /**
     * Monta a página HTML, porém não exibe no navegador
     * Retorna a página como uma 'String'
     */
    public function getHTMLPag(){
        ob_start();        
        if(isset($this->html_nome)) require_once $this->html_nome; /*Carrega a página HTML*/
        $this->html_pag = ob_get_contents();
        ob_end_clean();        
        return $this->html_pag;
    }

    /**
     * Exibe a página HTML no navegador
     */
    public function imprimirHTML(){        
        echo $this->getHTMLPag();
    }
}

?>
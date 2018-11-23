<?php
/**
 * Controlador do Condominios
 * 
 * @author Jonathas Assunção
 * @version 0.0.2
 * 
 * =================================================================
 * date - 23/11/2018 - @version 0.0.2
 * description: Muda chamada da view
 * =================================================================
 * date - 02/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              criação do método listar que 
 *              exibe a página HTML no navegador referente ao condominio
 * =================================================================
 * 
 * Dir  - Rotas
 * File - CondominiosRotas.php
 */
 
 //Inclui a classe model de negócio
 require_once 'Models/CondominiosModel.php';

 class CondominiosRotas{

    /**
     * Exibe a tela de Categoria
     * 
     */
    public function listarAction(){
        //Renderiza a página de Listar Condominios
        $view = new Views('Views/Sistema/admin/ListarCondominiosView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->imprimirHTML();
        
    }
    
    /**
     * Exibe a tela de Categoria
     * 
     */
    public function selecionarAction(){
        
        $view  = null; //Variavel que será usada para definir qual view o controller deve exibir
        $dados = null; //Variavel que será usada para receber os dados do model

        //Instancia a classe model, para pegar os dados para serem exibidos
        $cond = new CondominioModel();
        $dados = (object) $cond->getCondominios(); //$view é tratado por referencia

        //Verifica qual view deve exibir e Renderiza a página de Selecionar Condominios
        if($dados->getCodigoResposta()){ //Caso $view seja TRUE, exibe view de listar os condominios e passa os dados para a listagem
            $view = new Views('Views/Sistema/admin/SelecionarView.phtml', Array("header"=> "Escolha um Condomínio!", "dados"=> $dados->getMensagem()));
        }else{ //Caso $view seja FALSE, exibe view de erro e passa os dados do erro
            $view = new Views('Views/Sistema/admin/modalErroView.phtml', Array("header"=> "Erro ao listar Condomínios","body"=> $dados->getMensagem()));
        }
        
        //Retorna para o navegador a página HTML à ser exibida.
        $view->imprimirHTML();
        
    }    

    /**
     * Exibe a tela de Editar condominio
     * 
     */
    public function condominioAction(){
        //Renderiza a página de Selecionar Condominios
        $view = new Views('Views/Sistema/admin/CondominiosView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->imprimirHTML();
        
    }  

    /**
     * Exibe a tela de Categoria
     * 
     */
    public function mudarCondAction(){
        //Salva o condominio na session        
        $cnpj = substr($_POST['cond'], 0, 18);
        $cond = substr($_POST['cond'], 20);
        $condominio = new CondominioModel(); 

        //Verifica se o usuário que está logado tem permissão para acessar o controller e Action solicitado
        if($condominio->temPermissaoMudarCondominio('acessar', $cnpj)){ 
            /**Se entrou no IF, é porque tem a permissão... 
             * Agora modifica os parametros da Requisição e tenta importar o controller, e chamar a função Action solicitada
            */
            //Recarrega a página
            $_SESSION['cnpj'] = $cnpj;
            $_SESSION['cond'] = $cond.' ( '.$cnpj.' )';
            Roteador::definirRotas('Home.listar'); //Redireciona a rota para a página de principal do sistema
            Roteador::recarregarClient();          //Usuario não está logado, redireciona para tela de login 
        }else{ 
            /**
             * Se Entrou no ELSE, então o usuário não tem permissão para acessar esse controller e Action
             * Exibe um Modar de Atenção, informando a mensagem retornada pela Class LoginModel()
             */
            $view = new Views('Views/Sistema/admin/modalAtencaoView.phtml', Array("header"=> "Esse condomínio não pode ser selecionado!","body"=> "Motivo: ".$login->getMensagem()));
            $view->imprimirHTML();
        }

        
    }   
 }
?>
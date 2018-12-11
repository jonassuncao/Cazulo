<?php
/**
 * Controlador do Condomínios
 * 
 * @author Jonathas Assunção
 * @version 0.0.3
 *
 * =================================================================
 * date - 04/12/2018 - @version 0.0.3
 * description: Implementação da rota Condominio.excluir
 * =================================================================
 * date - 23/11/2018 - @version 0.0.2
 * description: Muda a forma da resposta para o HTML 
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
     * Rota Condominio.listar
     * Exibe a tela de Categoria
     * 
     */
    public function listarAction(){
        //Renderiza a página de Listar Condominios
        $view = new Views('Views/Sistema/Admin/listarCondominiosView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->imprimirHTML();
        
    }
    
    /**
     * Rota Condominio.selecionar
     * Exibe a tela de Selecinar um condomínio
     * 
     */
    public function selecionarAction(){

        //Solicita ao Model os condomínios que podem ser listados, e exibe na tela
        try{                       

            //Instancia a classe model, para pegar os dados para serem exibidos
            $cond = new CondominioModel();        
            $dados = $cond->getCondominios();             
            
            $view = new Views('Views/Sistema/Admin/selecionarView.phtml', Array("header"=> "Escolha um Condomínio!", "dados"=> $dados));            
            
            //Retorna para o navegador a página HTML à ser exibida.
            $view->imprimirHTML();
        }catch(Exception $e){//Trata as Exceções geradas

            //Pega a mensagem de erro gerada na exceção e retorna um Modal de erro com a mensagem
            $view = new Views('Views/Sistema/Admin/modalErroView.phtml', Array("header"=> "Falha ao Listar os Condomínios!","body"=> "Motivo: ".$e->getMessage()));
            $view->imprimirHTML();
        } 
    }    

    /**
     * Rota Condominio.condominio
     * Exibe a tela de Editar condominio
     * 
     */
    public function condominioAction(){
        //Renderiza a página de Selecionar Condominios
        $view = new Views('Views/Sistema/Admin/condominiosView.phtml');
        //Retorna para o navegador a página HTML à ser exibida.
        $view->imprimirHTML();
        
    }  

    /**
     * Rota Condominio.mudarCond
     * 
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
            $view = new Views('Views/Sistema/Admin/modalAtencaoView.phtml', Array("header"=> "Esse condomínio não pode ser selecionado!","body"=> "Motivo: ".$login->getMensagem()));
            $view->imprimirHTML();
        }

        
    }   

################################################################################################################################################################################################
        //recebe o cnpj do html e manda para o Model fazer a busca dos dados  
        public function buscarCond(){
      
           //Tenta baixar o condomínio da requisição, e exibe uma janela pedindo confirmação de exclusão.
            try{
            /** 
             * Baixa as variáveis que o HTML enviou na requisição.
             * 
             * Para baixar tem 3 formas:
             * 
             * $_GET[]  -> Baixa as variaveis passadas na requisição apenas como GET
             * $_POST[] -> Baixa as variaveis passadas na requisição apenas como POST
             * $_REQUEST[] -> Baixa as variaveis passadas na requisição pode ser GET, POST, ...
             */
            $cond = $_REQUEST['cond']; 
            
            /**
             * Para excluir um condomínio, será necessário informar o cnpj do condomínio a ser excluído.
             * Verifica se conseguiu baixar o CNPJ da requisição, ou se realmente foi passado o CNPJ na requisição (Se tem algum condomínio selecionado)
             * 
             * Caso a $cond == null, então não foi passado um cnpj para a requisição, então gera exceção
             *
             */
            if($cond == null) throw new Exception("Selecione um condomínio primeiro!");
            
            $condominio = new CondominioModel();//Criar conecção com Model
            $dadosCondominio = new ListarCondominiosView(); //Criar conecção com View
            $dadosCondominio = $condominio->listarCondominio($cond); //View recebe o retorno da busca do Model

        }catch(Exception $e){//Trata as Exceções geradas

            //Pega a mensagem de erro gerada na exceção e retorna um Modal de erro com a mensagem
            $view = new Views('Views/Sistema/Admin/modalErroView.phtml', Array("header"=> "Falha ao buscar condomínio!","body"=> "Motivo: ".$e->getMessage()));
            $view->imprimirHTML();
        }

        return $dadosCondominio; // retorno da function  
    }
################################################################################################################################################################################################


    /**
     * Rota Condominio.excluir
     * Exibe a um modal pedindo confirmação para excluir o condomínio
     * 
     */
    public function excluirAction(){
        
        //Tenta baixar o condomínio da requisição, e exibe uma janela pedindo confirmação de exclusão.
        try{
            /** 
             * Baixa as variáveis que o HTML enviou na requisição.
             * 
             * Para baixar tem 3 formas:
             * 
             * $_GET[]  -> Baixa as variaveis passadas na requisição apenas como GET
             * $_POST[] -> Baixa as variaveis passadas na requisição apenas como POST
             * $_REQUEST[] -> Baixa as variaveis passadas na requisição pode ser GET, POST, ...
             */
            $cond = $_REQUEST['cond']; 
            
            /**
             * Para excluir um condomínio, será necessário informar o cnpj do condomínio a ser excluído.
             * Verifica se conseguiu baixar o CNPJ da requisição, ou se realmente foi passado o CNPJ na requisição (Se tem algum condomínio selecionado)
             * 
             * Caso a $cond == null, então não foi passado um cnpj para a requisição, então gera exceção
             *
             */
            if($cond == null) throw new Exception("Selecione um condomínio primeiro!");
            

            //Define as variáveis para exibição do modal
            $titulo = "Confirma excluir o Condomínio?";
            $mensagem = "Ao confirmar, <b>todos</b> os dados do condomínio: $cond, serão excluído!!! <br/> Confirma?";
            $acao = 'requisitarServidor("index.php", "Condominios.confirmaExcluir", "cond='.$cond.'", "modal_resposta"); return false;';
            
            //Exibe 
            $view = new Views('Views/Sistema/Admin/modalConfirmaView.phtml', Array("header"=> $titulo,"body"=> $mensagem, "action" =>$acao));        
            $view->imprimirHTML();
        }catch(Exception $e){//Trata as Exceções geradas

            //Pega a mensagem de erro gerada na exceção e retorna um Modal de erro com a mensagem
            $view = new Views('Views/Sistema/Admin/modalErroView.phtml', Array("header"=> "Falha ao excluir condomínio!","body"=> "Motivo: ".$e->getMessage()));
            $view->imprimirHTML();
        }          
    }  


   /**
     * Rota Condominio.confirmaExcluir
     * 
     * Essa é a rota do condomínio que irá tratar quando for solicitado para um condomínio ser excluído!
     */
    public function confirmaExcluirAction(){

        //Tenta baixar as variáveis da requisição e encaminha para o Model excluir o condomínio
        try{
            /** 
             * Baixa as variáveis que o HTML enviou na requisição.
             * 
             * Para baixar tem 3 formas:
             * 
             * $_GET[]  -> Baixa as variaveis passadas na requisição apenas como GET
             * $_POST[] -> Baixa as variaveis passadas na requisição apenas como POST
             * $_REQUEST[] -> Baixa as variaveis passadas na requisição pode ser GET, POST, ...
             */
            $cond = $_REQUEST['cond']; //O cond virá com o formato: <nome Condominio> (99.999.999/9999-99)
            
            /**
             * Para excluir um condomínio, será necessário informar o cnpj do condomínio a ser excluído
             * Verifica se conseguiu baixar o cond da requisição, ou se realmente foi passado o CNPJ na requisição (Se tem algum condomínio selecionado)
             * 
             * Caso a $cond == null, então não foi passado um condomínio na requisição, então gera exceção
             *
             */
            if($cond == null) throw new Exception("Selecione um condomínio primeiro!");




            //=====Caso chegue aqui, então foi passado o CNPJ na requisição, esse cnpj está na variável $cond, no formato:  <nome Condominio> (99.999.999/9999-99)
            //Agora o condomínio será excluído

            //Instancia a classe Model do Condominio (O Model possui um método para deletar o condomínio)
            $condominio = new CondominioModel(); 
            $condominio->deletarCondominio($cond);
            




        //=====Caso chegue aqui, então o condominío foi excluído    
            //Limpa o condomínio da seção (Isso vai fazer com que o Desapareça no HTML o: <nome Condominio> (99.999.999/9999-99) que foi excluido)
            $_SESSION['cnpj'] = null;
            $_SESSION['cond'] = null;
            
            //Recarrega a página (Isso faz com que o servidor atualize a página, removendo os dados do condomínio no sistema)                       
            Roteador::definirRotas('Home.listar'); //Redireciona para a Rota Home (O usuário vai ter que escolher outro condomínio...)
            Roteador::recarregarClient();          //Recarrega a página para redirecionar para a página Home

        }catch(Exception $e){//Trata as Exceções geradas

            //Pega a mensagem de erro gerada na exceção e retorna um Modal de erro com a mensagem
            $view = new Views('Views/Sistema/Admin/modalErroView.phtml', Array("header"=> "Falha ao excluir condomínio!","body"=> "Motivo: ".$e->getMessage()));
            $view->imprimirHTML();
        }        
        
    }      
 }
?>
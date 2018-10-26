<?php
/**
 * Gerencia e processa o arquivo do extrato 
 * 
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 02/10/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              Gerencia os dados da Prestação de Contas
 * =================================================================
 * 
 * Dir  - models
 * File - ExtratoModel.php
 */

class ExtratoModel{
    private $header;
    private $fileArquivo;
    private $matrizConteudo;
    private $periodo;
    
    //Construtor
    function __construct($file) {      

        //Verifica se é um arquivo válido
        if (!is_uploaded_file($file['tmp_name'])) throw new Exception("Arquivo inválido!");

        //Copia para a pasta temporária interna do sistema

        $this->limpaDir(__DIR__.'/../temp/');
        if (!move_uploaded_file($file['tmp_name'], __DIR__.'/../temp/'.basename($file['name']))) throw new Exception("Erro ao salvar arquivo!");
        
        $this->header = Array();
        $this->matrizConteudo = Array();
        $this->fileArquivo = $file;
    }
    
    private function setDados(){
        //Abre o arquivo
        $arquivo = fopen(__DIR__.'/../temp/'.basename($this->fileArquivo['name']), "r");
       
        //Percorre todo o header do arquivo     
        while(!feof($arquivo)) {              
            //Lê uma linha do arquivo
            $linha = utf8_encode(fgets($arquivo)); //Ler um arquivo

            if($linha == "") continue; //Se for linha em branco carrega novamente

            //Tenta pegar o nome do Condominio
            if(!(strpos($linha, "Cliente:") === false)){                
                $this->header["Cliente"] = str_replace('Cliente:', '', $linha);                                        
                continue;
            }

            //Tenta pegar a conta do Condominio
            if(!(strpos($linha, "Conta:") === false)){                
                $this->header["Conta"] = str_replace('Conta:', '', $linha);                                        
                continue;
            }

            //Tenta pegar a data do extrato
            if(!(strpos($linha, "Data:") === false)){                
                $this->header["Data"] = str_replace('Data:', '', $linha);                                        
                continue;
            }
            
            //Tenta pegar o período do extrato
            if(!(strpos($linha, "Mês:") === false)){                
                $this->header["Periodo"] = str_replace('Mês:', '', $linha);
                
                /* Armazena o período convertido em número/ano */
                $this->periodo = $this->convertePeriodo($this->header["Periodo"]); 
                break;   
            }                                      
        }

        //Percorre todo os lançamentos do arquivo     
        while(!feof($arquivo)) {         
            //Lê uma linha do arquivo
            $linha = utf8_encode(fgets($arquivo)); //Ler um arquivo
            
            //Tenta pegar o lançamento do Condominio

            if(strpos($linha, $this->periodo) === 3){  
                //Pega Data
                $this->header["Periodo"] = substr($linha, 0, 10);
                //Pega NumDoc
                //Pega Desc
                //Pega valor
                //Pega Saldo
                /*$lancamento;              
                $this->header["Periodo"] = str_replace('Mês:', '', $linha);
                array_push($cesta, $lancamento);                */
            }                                                  
        }

        //Fecha o arquivo.
        fclose($arquivo);
        $this->limpaDir(__DIR__.'/../temp/');
    }

    //Retorna os dados do Header
    public function getHeader(){
        $this->setDados();
        return $this->header;
    }

    private function limpaDir($dir){
        $itens = glob(__DIR__.'/../temp/*.*'); 
        if ($itens !== false) {
            foreach ($itens as $item) {
                unlink($item);
            }
        }
    }

    private function convertePeriodo($periodo){
        
        $meses = Array("Janeiro" => "01", 
                       "Fevereiro" => "02", 
                       "Março" => "03", 
                       "Abril" => "04", 
                       "Maio" => "05", 
                       "Junho" => "06", 
                       "Julho" => "07", 
                       "Agosto" => "08", 
                       "Setembro" => "09", 
                       "Outubro" => "10", 
                       "Novembro" => "11", 
                       "Dezembro" => "12");
        
        return trim(str_replace(substr($periodo, 1, strlen($periodo)-8), $meses[substr($periodo, 1, strlen($periodo)-8)], $periodo));                       
    }
}

?>
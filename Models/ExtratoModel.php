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

    
    //Construtor
    function __construct($file) {      

        //Verifica se é um arquivo válido
        if (!is_uploaded_file($file['tmp_name'])) throw new Exception("Arquivo inválido!");

        //Copia para a pasta temporária interna do sistema
        unlink($file['tmp_name'], __DIR__.'/../temp/*.*');
        if (!move_uploaded_file($file['tmp_name'], __DIR__.'/../temp/'.basename($file['name']))) throw new Exception("Erro ao salvar arquivo!");
        
        $this->header = Array();
        $this->matrizConteudo = Array();
        $this->fileArquivo = $file;
    }

    private function setDados(){


        //Abre o arquivo
       $arquivo = fopen(__DIR__.'/../temp/'.basename($this->fileArquivo['name']), "r");
       
        //Percorre todo o arquivo
        $this->header["Cliente"] = "OPA:";          
        $i = 0;          
        while(!feof($arquivo)) {              
            //Lê uma linha do arquivo
            $linha = utf8_encode(fgets($arquivo)); //Ler um arquivo

            if($linha == "") continue; //Se for linha em branco carrega novamente

            //Tenta pegar o nome do Condominio
            if(!(strpos($linha, "Cliente:") === false)){                
                $this->header["Cliente"] = str_replace('Cliente:', '', $linha);                                        
                continue
            }

            //Tenta pegar o nome do Condominio
            if(!(strpos($linha, "Conta:") === false)){                
                $this->header["Conta"] = str_replace('Conta:', '', $linha);                                        
                continue
            }

            //Tenta pegar o nome do Condominio
            if(!(strpos($linha, "Data:") === false)){                
                $this->header["Data"] = str_replace('Data:', '', $linha);                                        
                continue
            }
            
            //Tenta pegar o nome do Condominio
            if(!(strpos($linha, "Mês:") === false)){                
                $this->header["Periodo"] = str_replace('Mês:', '', $linha);                                        
                continue
            }            
        }
        //Fecha o arquivo.
        fclose($arquivo);
        unlink($file['tmp_name'], __DIR__.'/../temp/*.*');
    }

    //Retorna os dados do Header
    public function getHeader(){
        $this->setDados();
        return $this->header;
    }
}

?>
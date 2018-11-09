<?php

/**
 * funções utilitárias
 * 
 * 
 * @author Jonathas Assunção
 * @version 0.0.1
 * 
 * =================================================================
 * date - 09/11/2018 - @version 0.0.1
 * description: Versão inicial do arquivo, 
 *              Adicionado funçãoque formata string
 * =================================================================
 * 
 * Dir  - lib
 * File - utilitarios.php
 */
        
/** 
 * Metodo aplica mascara em valor 
 * @param valor  string sem mascara
 * @param mascara mascara a ser aplicada
 */
function mascara($valor, $mascara){
    $stringMascara = '';
    $k = 0;

    for($i = 0; $i<=strlen($mascara); $i++){
        if($mascara[$i] == '#'){
            $stringMascara .= (isset($valor[$k]))?  $valor[$k++] : "#";
        }else{
            if(isset($mascara[$i])) $stringMascara .= $mascara[$i];
        }
    }
    
    return $stringMascara;
}

?>
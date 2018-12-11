<?php
/**
 * Define uma classe de exceção
 * 
 * Quando nãohouver condomínio
 */
class CondominioVazioException extends Exception
{
    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // código
    
        // garante que tudo está corretamente inicializado
        parent::__construct($message, $code, $previous);
    }
}
?>
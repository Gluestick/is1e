<?php

/**
 * Met behulp van deze class word de verbinding met de database geregeld.
 *
 * @author Hans-Jurgen
 */
class database {
    
    
    public static function getInstantie()
    {
        if (!self::$instantie)
        {
                self::$instantie = new self();
        }
        return self::$instantie;
    }
}
?>

<?php

/**
 * Met deze class kan een pagina volledig gebouwt worden.
 * De namen van de functies spreken voor zichzelf.
 * En hun doel ook.
 *
 * @author Hans-Jurgen
 */

class pagina
{
    private static $instantie;

    private $csspad;

    public $titel;
    public $meta_beschrijving;
    public $meta_sleutelwoorden;

    public $javascript;
    public $css;

    function __construct()
    {

    }

    public static function getInstantie()
    {
        if (!self::$instantie)
        {
                self::$instantie = new self();
        }
        return self::$instantie;
    }

    function setJavascript($src, $type = "text/javascript")
    {
        $this->javascript .= "<script type=\"".$type."\" src=\"".$src."\"></script>";
    }

    function setCss($src,$type = "text/css", $rel = "stylesheet")
    {
        $this->css .= "<link rel=\"".$rel."\" href=\"".$this->csspath.$src."\" type=\"".$type."\" />";
    }

    function setMetaKeyword($keyword)
    {
        $this->meta_keywords .= $keyword;
    }

    function setMetaDescription($description)
    {
        $this->meta_description .= $description;
    }

    function getVereisteHTML()
    {
        return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"> 
                <html lang=\"en-US\" xml:lang=\"en-US\" xmlns=\"http://www.w3.org/1999/xhtml\"> 
                <head>
                <title>".$this->title."</title>
                <link rel=\"shortcut icon\" href=\"/favicon.ico\" type=\"image/x-icon\" />
                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\" />
                <meta name=\"description\" content=\"".$this->meta_description."\" />
                <meta name=\"keywords\" content=\"".$this->meta_keywords."\" />
                ".$this->css."
                ".$this->javascript."
                </head>";
    }

    function render_noscript()
    {
        echo '<noscript><center><p class="noscript">Your browser does not support JavaScript!/doesn\'t have javascript enabled</p></center></noscript>';
    }

    function render_menu()
    {

    }

    function render_footer()
    {

    }
}
<?php

class specialetekens {
	
	const SMILEY_SMILE		= "smile_:)";
	const SMILEY_FRUSTY		= "frusty_|:(";
	const SMILEY_FROWN		= "frown_:(";
	const SMILEY_REDFACE	= "redface_:o";
	const SMILEY_BIGGRIN	= "biggrin_:)";
	const SMILEY_WINK		= "wink_;)";
	const SMILEY_CLOWN		= "clown_:+";
	const SMILEY_DEVIL		= "devil_}>";
	const SMILEY_CRY		= "cry_:'(";
	const SMILEY_PUH2		= "puh2_:P";
	const SMILEY_YUMMIE		= "yummie_:9";
	const SMILEY_SHINY		= "shiny_:*)";
	const SMILEY_HEART		= "heart_O+";
	const SMILEY_RC5		= "rc5_}:O";
	const SMILEY_YAWNEE		= "yawnee_:O";
	const SMILEY_VORK		= "vork_:Y)";
	const SMILEY_SLEEPHAPPY	= "sleephappy_:z";
	const SMILEY_SADLEY		= "sadley_;(";
	const SMILEY_COOOL		= "coool_8-)";
	const SMILEY_CONFUSED	= "confused_:?";
	const SMILEY_KWIJL		= "kwijl_:9~";
	const SMILEY_PUH		= "puh_:>";
	const SMILEY_NOSMILE	= "nosmile_:/";
	const SMILEY_NOSMILE2	= "nosmile2_:|";
	const SMILEY_SHUTUP		= "shutup_:X";
	const SMILEY_BONK		= "bonk_8)7";
	const SMILEY_HYPOCRITE	= "hypocrite_O-)";
	const SMILEY_WORSHIPPY	= "worshippy__/-\o_";
	const SMILEY_PANDA		= "panda_arjan";
	
	const BBCODE_B_START	= "[b]_<strong>";
	const BBCODE_B_END		= "[/b]_</strong>";
	const BBCODE_I_START	= "[i]_<i>";
	const BBCODE_I_END		= "[/i]_</i>";
	const BBCODE_U_START	= "[u]_<u>";
	const BBCODE_U_END		= "[/u]_</u>";
	
	
	/**
	 *
	 * @return smiley
	 */
	public static function getInstantie()
	{
		if (!self::$instantie) {
			self::$instantie = new self();
		}
		return self::$instantie;
	}
	
	/**
	 * Deze functie haalt de informatie van de specialetekens class op door de class
	 * op te halen als een reflectionclass.
	 * Door door de informatie te loopen en alleen de constanten op te halen waarin
	 * het woord smiley word gebruikt halen we hier alleen een array met de smiley
	 * tags op.
	 * @return array
	 */
	public static function getSmileys()
	{
		$smileys = array();
		$oReflectionClass = new ReflectionClass('specialetekens');
		foreach ($oReflectionClass->getConstants() as $key => $val) {
			if (strstr($key, "SMILEY")) {
				$smilies[$key] = $val;
			}
		}
		return $smilies;
	}
	
	/**
	 * Deze functie haalt de informatie van de specialetekens class op door de class
	 * op te halen als een reflectionclass.
	 * Door door de informatie te loopen en alleen de constanten op te halen waarin
	 * het woord BBCODE word gebruikt halen we hier alleen een array met de bbcode
	 * tags op.
	 * @return array
	 */
	public static function getBBCODE()
	{
		$bbcode = array();
		$oReflectionClass = new ReflectionClass('specialetekens');
		foreach ($oReflectionClass->getConstants() as $key => $val) {
			if (strstr($key, "BBCODE")) {
				$bbcode[$key] = $val;
			}
		}
		return $bbcode;
	}
	
	/**
	 * Deze functie kijkt of er smilies en bbcode in de meegegeven tekst staat.
	 * Als deze worden gevonden dan worden ze vervangen door de tags die in de constanten
	 * van deze class staan.
	 * @param string $tekst
	 * @return string
	 */
	public static function vervangTekensInTekst($tekst)
	{
		foreach (self::getBBCODE() as $array) {
			$bbcode = explode("_",$array,2);
			$tekst = str_replace($bbcode[0],$bbcode[1],$tekst);
		}
		
		foreach (self::getSmileys() as $array) {
			$smiley = explode("_", $array, 2);
			$tekst = str_replace($smiley[1], "<img src=\"/project/images/".$smiley[0].".gif\" />", $tekst);
		}
		return $tekst;
	}
}

?>
<?php
/**
 * Description of gebruiker
 *
 * @author Orion
 */
class gebruiker
{
	public static function checkValideUpload($code)
	{
		if ($code == UPLOAD_ERR_OK) {
			return;
		}

		switch ($code) {
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				$bericht = 'Afbeelding is te groot';
				break;
			case UPLOAD_ERR_PARTIAL:
				$bericht = 'De afbeelding is gedeeltelijk geupload';
				break;
			case UPLOAD_ERR_NO_FILE:
				$bericht = 'Geen afbeelding geupload';
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$bericht = 'De upload map is niet gevonden';
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$bericht = 'Kon de afbeelding niet wegschrijven';
				break;
			case UPLOAD_ERR_EXTENSION:
				$bericht = 'Kon afbeelding niet openen door onbekende extensie';
				break;
			default:
				$bericht = 'Onbekende error';
		}
		return $bericht;
	}
}

?>

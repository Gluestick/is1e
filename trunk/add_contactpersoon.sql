ALTER TABLE `vereniging` ADD `contactpersoon` VARCHAR( 45 ) NOT NULL;
UPDATE `project`.`vereniging` SET `contactpersoon` = 'Pietje Puk' WHERE `vereniging`.`verenigingid` =11;
UPDATE `project`.`vereniging` SET `contactpersoon` = 'Melis Brandenburg' WHERE `vereniging`.`verenigingid` =12;
UPDATE `project`.`vereniging` SET `contactpersoon` = 'Brigitte Beurskens' WHERE `vereniging`.`verenigingid` =13;
UPDATE `project`.`vereniging` SET `contactpersoon` = 'Fleurine de Kleijn' WHERE `vereniging`.`verenigingid` =14;
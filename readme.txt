De class config wordt aangemaakt bij het aanroepen van een pagina. Hier worden de inlog-gegevens van de database
opgeslagen. Die moet je daar handmatig aanpassen om in te kunnen loggen.

De database connectie wordt gemaakt mbv de class database. De class is een singleton dus hij wordt aangeroepen
met database::getInstantie(). Zo voorkomen we dat er meerdere db-connecties zijn. In __construct() wordt de
connectie daadwerkelijk gemaakt en de inlog-informatie wordt uit de class config gehaald.


Accounts:

Een account die vereniging, student én admin is.
username:	sadmin
password:	project

Een vereniging.
username:	buiten
password:	societeit

Een student.
username:	henk
password:	henker
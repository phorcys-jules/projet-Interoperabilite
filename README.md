# Projet Interoperabilite

:sparkles:  Projet Interoperabilite LP Ciasie / IUT Nancy Charlemagne / François Jules, Mangenot Alex, Wilt Lilian      :sparkles:	

Retrouvez le projet directement sur le serveur :
- https://webetu.iutnc.univ-lorraine.fr/www/wilt2u/Interop/circulations.php

- https://webetu.iutnc.univ-lorraine.fr/www/wilt2u/Interop/velos.php

:warning:   INDICATIONS :     :warning:	

- Le projet tel qu'il est dans le dépôt est configuré pour fonctionner en local, avant de déployer sur serveur, il est impératif de suivre les indications laissées en commentaires sur les fichier circulations.php (ligne 34 & 82) et velos.php (lignes 3, 9 & 19).

- Il est possible d'avoir une erreur "XSLTProcessor not found" en ouvrant le fichier velos.php en utilisant XAMPP, pour cela il faut :
- :arrow_right:	Ouvrir le fichier php.ini se trouvant : path_to_installation_of_xampp/php/php.ini
- :arrow_right:	En utilisant CTRL+F, rechercher "extension=xsl" et enlever le commentaire se trouvant à cette ligne

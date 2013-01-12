
Eine Auftragsmanagement System für Kleine bis Mittelständische Betriebe die auf Montage oder beim Kunden arbeiten. 

Entwicklung der zweiten Version mit einem Überarbeiteten Layout.


Installation
--------------------

Nach dem Clonen des Repositorys, muss eine Parameters.yml Datei erstellt werden unter app/config  

    parameters:
      database_driver: pdo_mysql
      database_host: 127.0.0.1
      database_port: null
      database_name: workbook
      database_user: db_user
      database_password: db_password
      mailer_transport: smtp
      mailer_host: 127.0.0.1
      mailer_user: null
      mailer_password: null
      locale: de
      secret: e8dc07cc7f7b214b7f667dc7777fecec0bd25692
      database_path: null


noch die Datenbank eingerichtet werden, über die Konsolenbefehle

    php app/console doctrine:database:create 

und dann um die Tabellen zu erstellen. 

    php app/console doctrine:schema:create --force
    

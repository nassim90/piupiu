# piupiu

Projet 5 OpenClassRooms

## Contrainte technique
* symfony 3

## Guide d'installation
  * `git clone git@github.com:OCR-P5/piupiu.git InstallDirectory`
  * `cd InstallDirectory`
  * `composer update`
  * Provide parameters or change `parameters.yml` later
    * database_host: _default_
    * database_port: _default_
    * database_name: **piupiu**
    * database_user: **YourUser**
    * database_password: **YourPwd**
    * mailer_transport: _default_
    * mailer_host: _default_
    * mailer_user: _default_
    * mailer_password: _default_
    * secret: **yourSecretKey**
    * google_api: **yourGoogleMapsApiKey**
  * Create database
    * `php/bin console d:d:c`
  * Create schema
    * `php/bin console d:s:c`
  * Load fixtures
    * `php/bin console d:f:l`
  * Run server
    * `php/bin console s:r`
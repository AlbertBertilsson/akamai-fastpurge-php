# akamai-fastpurge-php
Minimal implementation of Akamai Fast Purge in PHP

## usage
```php fast-purge.php <string domain> <path> [<paths> ...]```

## credentials
To use this you must have your Akamai credentials available and configured in an .edgerc file residing in your user catalog.

Example:
```
[default]
host = akab-<your secret stuff...>.purge.akamaiapis.net
client_token = akab-<secret 2>-<secret 3>
client_secret = <secret 4>
access_token = akab-<secret 5>-<secret 6>
```

## sources
Shamelessly inspired and copied bits and pieces from:
https://github.com/akamai/api-kickstart
https://stackoverflow.com/questions/39477005/akamai-fast-purge-using-php-5-3

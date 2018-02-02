# To get started
```
$ composer install
```

setup app/config/parameters.yml

```
$ php bin/console doctrine:schema:update --force
$ php bin/console cache:clear --no-warmup --env=prod

# Run test
$ ./vendor/bin/phpunit
```

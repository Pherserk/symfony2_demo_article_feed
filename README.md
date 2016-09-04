symfony2_demo_article_feed
==========================

A Symfony project created on August 26, 2016, 7:04 pm.w
 
Instructions
============ 
 - Installation:
   - openssl genrsa -out var/jwt/private.pem -aes256 4096
   - openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
   - composer install
   - app/console cache:clear --env=dev
   - app/console cache:clear --env=test
   - app/console docrtine:schema:create --env=test
   - app/console doctrine:schema:create --env=dev
   - app/console assetic:dump --env=dev
   - app/console assetic:dump --env=test
   - app/console assets:install --symlink web
   - app/console debug:container jwt and press 0 (should be the 'lexik_jwt_authentication.jwt_encoder' option)

   
 - Run test suite: 
   - bin/phpunit -c app/
   
 - Launch the command that triggers the notification to the user with notifications older than 24 hours: 
   - app/console notify:quotes --hours=24
   
 - Try the write article route:
   - app/console doctrine:fixtures:load --env=dev
   - app/console server:start --force
   - point your browser to http://127.0.0.1:8000/app_dev.php/new
   - after being redirect to the login insert these credential: Username1, password1
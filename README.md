symfony2_demo_article_feed
==========================

A Symfony project created on August 26, 2016, 7:04 pm.

Goal:
 - The goal is to create an API that will allow to create an article, answer to an article, rate an article (between 0 and 5 ==> 0, 1, 2, 3, 4, 5)
 - This API should also include to retrieve an article and all its answers
 - Write some unit tests.

Bonus 1:
 - Write a front page that will allow us to write an article (keep it simple)

Bonus 2:
 - Write a command that will send an email to the writer of an article if he has notifications from more than 24 hours.


We expect to see quality code, well decoupled and to understand how you think. Surprise us!

Context:
 - ~3Hours
 - Symfony2
 - github
 
Instructions
============ 
 - Installation: composer install
 - Run test suite: bin/phpunit -c app/
 - Launch the command that triggers the notification to the user with notifications older than 24 hours: app/console notify:quotes --hours=24
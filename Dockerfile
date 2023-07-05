FROM php:7.0-apache
COPY application/ /var/www/html/
EXPOSE 80
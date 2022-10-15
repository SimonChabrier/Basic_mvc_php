Simple Php project based on a MVC struture

### Version pour tourner sur localhost et avec MySql
```
php -S localhost:8000 -t public
```

```
composer install
```
- create a 'assets' directory in public directory
- create a 'images' directory in this assets directory
- place a deault picture named default.jpg in 'images' directory

Be careful to have RW rigths on this 'images' directory to be able to upload files
```
chmod 777 images
```
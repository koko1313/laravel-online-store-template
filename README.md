# Online shop template

Something like framework that helps you easy create your web store.
The project is built by components that can be implemented and combinated to work together.

## Components

- **Alert messages**- alert messages that show errors, warnings and success information to the user.
- **User system** - the user system, containing login, register, and profile manager components.
- **Carousel** - page header with images (something like a slideshow).
- **Contact form** - a simple contact form that sents email directly to administrator e-mail.
- **Store** - the actual store with categories, products, and ordering functions.

## Install project
1. To run this project, you need **composer** to be installed. Then in the terminal run

```
composer update
```

2. In **components-guide** folder there is **templatedb.sql** file. This file contains database startup SQL code.

3. Copy **.env.example** file, rename it to **.env** and manage database connection in it.

4. In **config/database.php**

```php
strict => false
```

5. In terminal run

```
php artisan key:generate
```

## Using of the components

- [**Aler messages**](../master/components-guide/alert-messages.md)
- [**User system**](../master/components-guide/user-system.md)
- [**Carousel**](../master/components-guide/carousel.md)
- [**Contact form**](../master/components-guide/contact-form.md)
- [**Store**](../master/components-guide/store.md)

## Packages needed

[https://packagist.org/packages/gumlet/php-image-resize](https://packagist.org/packages/gumlet/php-image-resize)
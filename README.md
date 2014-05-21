# SimplePHP

SimplePHP is a PHP web framework for MVC-style websites. It's designed to be very simple and customizable to meet anyone's needs.

## Configuring

Create `config.php` from the `config.php.sample` template.

## Creating and populating the databases

Databases are not auto-populated. The base framework requires a table called `users` with an int *id*, varchar *account_name*, varchar *email*, and varchar *password_hash*.

## Remaining work

SimplePHP is still a work in progress. Important components like session management, i18n, etc. have not been started yet. Let me know if you'd like to get involved.

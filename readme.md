# novaworkflows.com

Here is the complete source code for NovaWorkflows.com

# Setup
```
git clone git@github.com:nova-workflows/website.git <some-folder>
```

Install Nova ([https://nova.laravel.com/docs/2.0/installation.html](Link))

```
composer update
```
```
php artisan migrate
php artisan nova:user
```

### Github
```php
GITHUB_CLIENT_ID=<oauth-app-id>
GITHUB_CLIENT_SECRET=<oauth-app-secren>
GITHUB_CLIENT_URL=<oauth-callback-url>
GITHUB_OWNER=<username-or-org>
GITHUB_TOKEN=<personal-token>
```

Replace config settings

```
services.github.author
```

TODO: seeders

```
phpunit
```

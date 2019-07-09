# novaworkflows.com

Here is the complete source code for novaworkflows.com

```
git clone git@github.com:nova-workflows/website.git <some-folder>
```

> install Nova / auth.json etc

```
composer update
cp .env.example .env
php artisan key:generate
```
> add local db connection
```
php artisan migrate
php artisan nova:user
```

```php
GITHUB_CLIENT_ID=<oauth-app-id>
GITHUB_CLIENT_SECRET=<oauth-app-secren>
GITHUB_CLIENT_URL=<oauth-callback-url>
GITHUB_OWNER=<username-or-org>
GITHUB_TOKEN=<personal-token>
```

> replace config settings

```
services.github.author
```

```
php artisan db:seed
```

```
phpunit
```

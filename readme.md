Cognito must be set to accept requests via USER_PASSWORD_AUTH  

You will need the following values in your .env file

```
AWS_COGNITO_KEY=
AWS_COGNITO_SECRET=
AWS_COGNITO_REGION=
AWS_COGNITO_CLIENT_ID=
AWS_COGNITO_CLIENT_SECRET=
AWS_COGNITO_USER_POOL_ID=
```

Until this is packaged properly, it can be retrived by adding the following to your composer.json

```
"repositories": [
    {
        "type": "vcs",
        "url":  "https://github.com/harveydobson/aws-cognito-laravel.git"
    }
```

And then running 

```
composer require harveydobson/aws-cognito-laravel
```


Once composer has installed the package, you can activate it by running

```
php artisan cognito:install
```

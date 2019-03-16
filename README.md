Ldap database and ActiveRecord for Yii 2
===========

This extension provides the LDAP integration for the Yii framework 2.0. 
It includes basic querying/search support and also implements the ActiveRecord 
pattern that allows you to store active records in Active Directory or OpenLDAP.

## Disclaimer

This is a fork of https://github.com/chrmorandi/yii2-ldap

Only to have some maintainability over the code and have a production release of the composer package


[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chrmorandi/yii2-ldap/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chrmorandi/yii2-ldap/?branch=master)

## Changelog

[See Changelog ](CHANGELOG.md)

Requirements
------------

To use yii2-ldap, your sever must support:

PHP LDAP Extension


## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist websvc/yii2-ldap
```

or add

```json
"websvc/yii2-ldap": "*"
```

to the require section of your composer.json.

## Configuration

```php
return [
    //....
    'components' => [
        'ldap' => [
            'class' => 'websvc\ldap\Connection',
            // Mandatory Configuration Options
            'dc' => [
                '192.168.1.1',
                'ad.com'
            ],
            'baseDn'          => 'dc=ad,dc=com',
            'username'        => 'administrator@ad.com',
            'password'        => 'password',
            // Optional Configuration Options
            'port'            => 389,
            'followReferrals' => false,
            'useTLS'          => true,
            // Change pageSize (e.g. to 1000) if you are getting the following message
            // with large result sets:
            // ldap_search(): Partial search results returned: Sizelimit exceeded
            'pageSize'        => -1,
            // Change the attribute to use for login
            'loginAttribute'        => 'uid',
            // for check if user has access to application
            'authAccess'      => [
                'cn' => 'cn=restricted,ou=Groups',  // Cn name, will be concatenated with baseDn
                'objectClass' => 'posixGroup',      // object class to search
                'attributeMatch' => 'memberUid',    // attribute to match user
            ]
        ],
    ]
];
```

### Authente User

To authenticate users using your AD server, call the `Yii::$app->ldap->auth()`
method on your provider:

```php
try {
    if (Yii::$app->ldap->auth($this->username, $password)) {
        // Credentials were correct.
    } else {
        // Credentials were incorrect.
    }
    } catch (Exception $e) {
        // error
    }
}
```

### Authenticate User, check access and retrieve user data

To authenticate users using your AD server, call the `Yii::$app->ldap->auth()`
method on your provider:

```php
try {
    $ldap = Yii::$app->ldap;

    if($ldap->auth($this->username, $this->password)) { //Yii loginform username/password

        $user_data = $ldap->checkAccessReturnUserdata();

        if( !empty($user_data)){

            if ($this->_user === null) {
                // Do your magic
                echo '<pre>';
                print_r($user_data);
                echo '</pre>';
            }
        }
    } else {
        // Credentials were incorrect.
        // Will not return anything
    }
} catch (Exception $e) {
    // error
    // Will not return anything
}
```

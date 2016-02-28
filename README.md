# SecurityResolverBundle

This is a bridge between Symfony2 or Symfony3 and [Madlines Security Resolver](https://github.com/Madlines/Common-Security-Resolver).

## Installation

```
composer require madlines/security-resolver-bundle
```

then update your AppKernel.php

```php
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Madlines\SecurityResolverBundle\MadlinesSecurityResolverBundle(),
            // ...
        ];

        // ...

        return $bundles;
    }
```


## Configuration

Prepare your voters like that:
```php
<?php

class PostEditVoter
{
    public function isGranted($user, $task)
    {
        // if (!($task instanceof PostEditTask)) {
        if ($task !== 'post_edit') {
            return null; // null means 'ignore'
            // returning integer 0 means the same
        }

        if ($user->hasRole('ROLE_ADMIN')) {
            return true; // agree
            // returning integer 1 means the same
        }

        return false; // disagree
        // returning integer -1 means the same
    }
}
```

Then connect each voter as a tagged service:

```yaml
    voter.post_edit:
        class: PostEditVoter
        public: false
        tags:
            - { name: madlines.security_resolver.voter }

```

Optionally you can change a voter's method name by adding a `method` attribute to a tag.

## Usage

Execute `isGranted` method on security resolver's service which is registered as `madlines.security_resolver.access_resolver`.
For example:

```php
$isGranted = $this->get('madlines.security_resolver.access_resolver')->isGranted(
    $this->getUser(),
    'post_edit'
);

if (!$isGranted) {
    throw new Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException();
}
```



# CumulusDemo plugin
## Introduction
It is a great plugin to help you understand how Cumulus works. It may be used with [Cumulus theme] to boost creation of SaaS app.

## Documentation
The plugin is created just for demonstration purpose, to show you how Cumulus works and behaves with example feature and data.

### `php artisan cumulus:seed`
The command will seed some initial, example data that will make [Cumulus theme]() fully work. It will:

1. register two features: `initbiz.cumulusdemo.free_feature` and `initbiz.cumulusdemo.paid_feature`,
1. create Free plan with access to `free_feature` only
1. create Full plan with access to `free_feature` and `paid_feature`
1. create cluster ACME corp. with Free plan
1. create Foo Bar with Full plan
1. seed example user (with demo@example.com / demo credentials) and give him access to both clusters,
1. configure auto assigning users to:
    1. create new clusters based on company name given in register form
    1. assign new clusters to free plan
1. configure user settings to:
    1. sign in using e-mail
    1. throttle attempts
    1. allow user registration
    1. automatically activates newly registered users

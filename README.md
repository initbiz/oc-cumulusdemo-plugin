# CumulusDemo plugin
## Introduction
The plugin has been created to help you understand how [CumulusCore](https://octobercms.com/plugin/initbiz-cumuluscore) plugin works.

It may be used with [Cumulus theme](https://octobercms.com/theme/initbiz-cumulus) to boost creation of SaaS app.

The plugin is created just for demonstration purpose, to show you how Cumulus works and behaves with example feature and data. It is not required by Cumulus to work.

See it in action in the following video:

[![Cumulus demo video thumbnail](https://github.com/initbizlab/oc-cumuluscore-plugin/raw/master/docs/images/youtube_demo_screenshot.png)](https://www.youtube.com/watch?v=Y0-OvGzmP5w)

## Documentation
Right now the plugin has only one purpose: seed [CumulusCore](https://octobercms.com/plugin/initbiz-cumuluscore) based application with example data and configure the environment.

To do this you have to run `php artisan cumulus:seed` command.

The command will seed some initial, example data that will make [Cumulus theme](https://octobercms.com/theme/initbiz-cumulus) work. It will:

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

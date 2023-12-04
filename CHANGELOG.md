CHANGE LOG
==========


## V12.4 (04/12/2023)

* Added PHP 8.3 support
* Require knplabs/github-api 3.13


## V12.3 (08/10/2023)

* Require knplabs/github-api 3.12


## V12.2 (10/03/2023)

* Require knplabs/github-api 3.11


## V12.1 (09/03/2023)

* Require knplabs/github-api 3.10


## V12.0 (07/03/2023)

* Support Laravel 8-10 only
* Support PHP 7.4-8.2 only
* Added additional types
* Removed various getter methods
* Require knplabs/github-api 3.9
* Require lcobucci/jwt `^4.3 || ^5.0`


## V11.0 (31/05/2022)

* Dropped PHP < 7.4
* Dropped Laravel < 8
* Require lcobucci/jwt ^4.1.5


## V10.6 (30/05/2022)

* Require knplabs/github-api 3.6
* Support graham-campbell/bounded-cache v2 too


## V10.5 (24/01/2022)

* Require knplabs/github-api 3.5


## V10.4 (24/01/2022)

* Support Laravel 9
* Require knplabs/github-api 3.4


## V10.3.1 (21/11/2021)

* Provisional PHP 8.1 support
* Updated package metadata


## V10.3 (23/05/2021)

* Require knplabs/github-api 3.3


## V10.2 (03/05/2021)

* Require knplabs/github-api 3.2


## V10.1 (14/03/2021)

* Require knplabs/github-api 3.1


## V10.0.2 (14/01/2021)

* Always build keys using integer timestamps


## V10.0.1 (08/01/2021)

* Tweaked private token auth


## V10.0 (22/12/2020)

* Require knplabs/github-api 3.0
* Removed password authenticator
* Added PHP 8.0 support


## V9.8 (22/12/2020)

* Require knplabs/github-api 2.19


## V9.7.1 (12/12/2020)

* Corrected phpdoc


## V9.7 (12/12/2020)

* Require knplabs/github-api 2.18


## V9.6 (27/11/2020)

* Require knplabs/github-api 2.17
* Upgrade to lcobucci/jwt ^3.4 || ^4.0
* Manager phpdoc fixes


## V9.5 (09/11/2020)

* Require knplabs/github-api 2.16


## V9.4 (16/08/2020)

* Support Laravel 8


## V9.3.1 (15/07/2020)

* Avoid deprecated authentication methods


## V9.3 (14/07/2020)

* Require knplabs/github-api 2.15
* Added missing cachefactory provides


## V9.2.1 (25/06/2020)

* Fixes for case sensitive filesystems
* Issue JWT tokens for 9m59s rather than 10m


## V9.2 (26/04/2020)

* Require knplabs/github-api 2.14


## V9.1.1 (14/04/2020)

* Updated funding information


## V9.1 (17/03/2020)

* Require knplabs/github-api 2.13


## V9.0.1 (01/03/2020)

* Fixed typo in requirements


## V9.0 (01/03/2020)

* Dropped Laravel 5
* Moved around internals
* Reworked caching support


## V8.6 (08/02/2020)

* Fixed deprecated in app auth
* Made caching truely optional


## V8.5 (25/01/2020)

* Added Laravel 7 support


## V8.4 (18/12/2019)

* Support directly providing a key to the private authenticator
* Fixed docs and example config for the private authenticator


## V8.3.1 (08/12/2019)

* Added missing properties


## V8.3 (03/11/2019)

* Require knplabs/github-api 2.12
* Support both HTTPlug v1 and v2


## V8.2 (26/08/2019)

* Added Laravel 6 support


## V8.1 (18/08/2019)

* Work around Laravel caching bugs
* Ensure cache TTLs aren't too large


## V8.0 (30/06/2019)

* Reworked caching
* Avoid calling deprecated code


## V7.8 (16/06/2019)

* Added private key authenticator


## V7.7 (07/04/2019)

* Added Laravel 5.8 support


## V7.6 (28/01/2019)

* Require knplabs/github-api 2.11


## V7.5 (04/09/2018)

* Support knplabs/github-api 2.10 too


## V7.4 (23/08/2018)

* Added Laravel 5.7 support
* Support knplabs/github-api 2.9 too


## V7.3 (02/04/2018)

* Support no authentication


## V7.2 (24/03/2018)

* Support knplabs/github-api 2.8 too


## V7.1 (18/03/2018)

* Use the new cache plugin package


## V7.0 (01/03/2018)

* Support PHP 7.1 or 7.2
* Support Laravel 5.5 or 5.6
* Support knplabs/github-api 2.7


## V6.2.1 (02/01/2018)

* Fixed config when inside phar


## V6.2 (28/12/2017)

* Support knplabs/github-api 2.7 too
* Fixed manager dynamic method phpdoc


## V6.1 (07/10/2017)

* Support knplabs/github-api 2.6 too


## V6.0 (06/08/2017)

* Support PHP 7.0, 7.1, 7.2
* Support Laravel 5.1 - 5.5
* More type hints
* Added JWT authentication support
* Rolled a custom caching plugging
* Locked to knplabs/github-api 2.5


## V5.1 (01/01/2017)

* Added laravel 5.4 support


## V5.0 (11/12/2016)

* Upgraded to the newest upstream library


## V4.4.2 (09/06/2016)

* Fixed lumen support


## V4.4.1 (05/06/2016)

* Use our own log adapter


## V4.4 (05/06/2016)

* Added support for logging


## V4.3 (26/04/2016)

* Added laravel 5.3 support
* Added cache configuration
* Added optional backoff support


## V4.2.1 (30/01/2016)

* Improved service provider
* Fixed some typos


## V4.2 (14/11/2015)

* Added laravel 5.2 support
* Improved environment detection


## V4.1 (06/10/2015)

* Improved lumen support


## V4.0 (26/06/2015)

* Official lumen support
* Code cleanup
* Moved the factory
* Container binding improvements


## V3.2 (25/05/2015)

* Added more configuration


## V3.1 (07/05/2015)

* Support both laravel 5.0 and 5.1
* Dropped php 5.4 support


## V3.0 (17/02/2015)

* Supporting all authentication methods


## V2.0 (05/02/2015)

* Upgraded to laravel 5.0


## V1.0.1 (11/01/2015)

* Removed the cs fixers
* CS fixes
* Moved to the MIT license


## V1.0 (19/10/2014)

* Improved the test suite
* Added cs fixers to the test suite
* Increased the minimum upstream version
* Improved the docs
* Other minor tweaks


## V0.1.1 Alpha (12/08/2014)

* Expose the factory class in the ioc
* Corrected the license comments
* Added dynamic method docs to the manager
* Other minor tweaks


## V0.1 Alpha (27/07/2014)

* Initial testing release

# CodeIgniter_dossiers
Under CodeIgniter and this manages Dossiers.

## What CodeIgniter_dossiers can do?
Code_igniter dossiers manages dossiers where you can **atacch**
- files, 
- texts, 
- images, 
- accounting notes, with 
   - date, 
   - concept, 
   - debit, 
   - credit and 
   - balance.

It's is ideal to manages many data in your company.

## Installation
Download or git clone **CodeIgniter_dossiers**, after it, 

- Install @benedmunds/CodeIgniter-Ion-Auth https://github.com/benedmunds/CodeIgniter-Ion-Auth.git
- copy (or move) to your **CodeIgniter** `application/third_party`
- copy (or move) `application/third_party/CodeIgniter_dossiers/controllers/Dossiers.php` to **your application folder**
- copy (or move) `application/third_party/CodeIgniter_dossiers/migrations/004_Install_dossiers.php` to **your migration folder**, tipically `application/migrations`
- edit yout `application/config/autoload.php` as follow:
```php
/*
| -------------------------------------------------------------------
|  Auto-load Packages
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
*/
$autoload['packages'] = array(
                              APPPATH.'third_party/ion_auth/',                              
                              APPPATH.'third_party/CodeIgniter_dossiers/'
                              );
```

- Do how you usually do up the migration, however, in change if you need the name of `third_party/CodeIgniter_dossiers/migrations/004_Install_dossiers.php` to to make it match your installation.

Enjoy  :+1:

```
Pedro Ruiz Hidalgo
@pedroruizhidalg
correo@pedroruizhidalgo.es

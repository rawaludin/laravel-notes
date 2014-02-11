Laravel 4 Artisan Notes Management
=============

Inpired by Rails Rake notes, Laravel Notes helps you manage your notes when developing an application. It will search comment begin with TODO, FIXME, or OPTIMIZE.

## Installation

+ Update your composer.json to require `"rahmatawaludin/laravel-notes": "dev-master"` 
```json
{
  "require": {
    "laravel/framework": "4.1.*",
    "rahmatawaludin/laravel-notes": "dev-master"
  },
  ...
}
```

+ Run `composer update` in the Terminal
+ Add the LaravelNotesServiceProvider `'Rahmatawaludin\LaravelNotes\LaravelNotesServiceProvider'` to the laravel providers array in the file `app/config/app.php`

```
'providers' => array(
	...
	'Rahmatawaludin\LaravelNotes\LaravelNotesServiceProvider'
  )
```

## Usage

Add your comment to file within `app` directory begin with TODO, FIXME, or OPTIMIZE.
example:

app/controllers/HomeController.php:
```
...
// TODO create different layout
...
```

app/routes.php
```
// FIXME missing controller for router
```

app/models/User.php
```
/** 
 * This is really important
 * OPTIMIZE better looping for this model
 * @var string
 */
```

Then use `notes` in terminal to view all notes:
```
$ php artisan notes
```


## Screenshot

![alt text](https://raw.github.com/rahmatawaludin/laravel-notes/master/screenshot.png "Notes Screenshot")

## Roadmap
Version | Feature 
--- | --- 
~~1.0~ | ~~Basic viewing notes~~
1.1 | Filter notes by type
1.2 | Filter notes by custom type
2.0 | Use git to speedup notes lookup 
2.1 | View notes on specific directory
2.2 | Any idea?

## Contribute
1. Fork
2. Work on dev branch
3. Pull
4. Repeat.. :)

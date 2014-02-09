# 3DFace/promise

Yet another implementation of CommonJS [Promises/A](http://wiki.commonjs.org/wiki/Promises/A) pattern for PHP.

Initial purpose of the project was to clarify `Promises` pattern in my head.
After implementing it I found it quite lightweight and clean. So I decided to share.

About `on_progress`.

At first I tried to implement it.
But for now I believe that this feature does not fit into the idea of the pattern.
In my opinion, `Promises` was intended to organize a flow control.
While `on_progress` appears to solve application specific problems. 
So I rejected it.


## Setup

Add to your composer.json file:

``` json
 
{
   "require": {
      "3DFace/promise": "*"
  }
}
```

Library organized according to PSR-0. 

So you can use composer autoloader:
``` php
require 'vendor/autoload.php';
```
or use custom PSR-0 loader.

Most of the package will work with PHP 5.4,
but if you want to use `Flow` you have to switch to >=5.5 to make generators available.


## Usage

``` php
require 'vendor/autoload.php';

use dface\promise\Deferred;

$x = new Deferred();

$x->then(function($val){
    echo "fulfilled: $val\n";
})->trap(function($e){
    echo "rejected: $e\n";
})->end(function(){
    echo "finished\n";
});

$x->fulfill(1);

```

You can see that in addition to the classical `then` there are two 'sugar' methods - `trap` to catch rejects,
and `end` to make finalization.

At this moment there are not so much usage examples. Please, take a look at unit tests to see more.


## Tests

```
phpunit --bootstrap tests/bootstrap.php tests/
```

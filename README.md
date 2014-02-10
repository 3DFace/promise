# dface/promise

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
		"dface/promise": "dev-master"
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

I will not explain the concept of the promises here. I will assume that you are already familiar with them.
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

You will find standard set of promises in this package: `Fulfilled`,  `Rejected`,  `Deferred`,  `All`,  `Some`,  `Race` and `Flow`.

I'd like to show you a fabricated example of `Flow` promise.
``` php
$x = new Flow(function () {
	$v1 = (yield promiseProducer1());
	$v2 = (yield promiseProducer2());
	$v3 = (yield promiseProducer3($v1, $v2));
	yield $v3;
});
```
`Flow` promise works like an envelope for its 'flow function'. In that function you can use special syntax to work with promises.
Instead of chaining promises with `then` you can describe execution flow in a straightforward manner just like you do in a synchronous world.
All you have to do is to preface your promises with `yield` keyword. `Flow` will make the rest behind the scene.

``` php
$x = new Flow(function () {
	$v1 = (yield promiseProducer1());
	try{
		$v2 = (yield promiseProducer2($v1));
	}catch(Exception $e){
		$v2 = (yield promiseProducer3($v1));
	}
	yield $v2;
});
```
You can see that you can `catch` rejected promises with `try...catch` constructions.

## Tests

```
phpunit --bootstrap tests/bootstrap.php tests/
```

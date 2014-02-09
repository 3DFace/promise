<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

/**
 * Main purpose of this class is to simplify coding of promise-based flow control.<br>
 * It uses PHP 5.5 generators to implement some 'magic'.
 * @package dface\promise
 */
class Flow extends CallbackPromise {

	function __construct($flow_func){
		parent::__construct(function ($fulfil, $reject) use ($flow_func){
			/** @var \Generator $generator */
			$generator = $flow_func();
			$first_yielded = $generator->current();
			self::next($first_yielded, $generator, $fulfil, $reject);
		});
	}

	private static function next($yielded, \Generator $generator, $flow_fulfil, $flow_reject){
		(new Fulfilled($yielded))->then(function ($value) use ($generator, $flow_fulfil, $flow_reject){
			try{
				$next_yielded = $generator->send($value);
				if(!$generator->valid()){
					$flow_fulfil($value);
				}else{
					self::next($next_yielded, $generator, $flow_fulfil, $flow_reject);
				}
			}catch(\Exception $e){
				$flow_reject($e);
			}
		}, function ($e) use ($generator, $flow_fulfil, $flow_reject){
			try{
				$next_yielded = $generator->throw($e);
				self::next($next_yielded, $generator, $flow_fulfil, $flow_reject);
			}catch(\Exception $e){
				$flow_reject($e);
			}
		});
	}

}

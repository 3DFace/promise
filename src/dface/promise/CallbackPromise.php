<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class CallbackPromise extends AbstractPromise {

	/** @var Deferred */
	protected $deferred;

	function __construct($resolver){
		$this->deferred = new Deferred();
		try{
			call_user_func($resolver, function ($result){
				$this->deferred->fulfill($result);
			}, function ($reason){
				$this->deferred->reject($reason);
			});
		}catch(\Exception $e){
			$this->deferred->reject($e);
		}
	}

	function then(callable $on_fulfill = null, callable $on_reject = null){
		return $this->deferred->then($on_fulfill, $on_reject);
	}

}

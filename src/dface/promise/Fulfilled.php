<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class Fulfilled extends AbstractPromise {

	protected $value;

	function __construct($value = null){
		$this->value = $value;
	}

	function then(callable $on_fulfill = null, callable $on_reject = null){
		$fulfill_result = $this->value;
		if($fulfill_result instanceof Promise){
			return $fulfill_result->then($on_fulfill, $on_reject);
		}else{
			if($on_fulfill){
				try{
					$fulfill_result = call_user_func($on_fulfill, $fulfill_result);
					return new Fulfilled($fulfill_result);
				}catch(\Exception $e){
					return new Rejected($e);
				}
			}else{
				return $this;
			}
		}
	}

} 

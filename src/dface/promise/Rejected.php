<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class Rejected extends AbstractPromise {

	protected $value;

	function __construct($value = null){
		$this->value = $value;
	}

	function then(callable $on_fulfill = null, callable $on_reject = null){
		if($on_reject){
			$reject_reason = $this->value;
			if($reject_reason instanceof Promise){
				return $reject_reason->then($on_reject, $on_reject);
			}else{
				try{
					$fulfill_result = call_user_func($on_reject, $reject_reason);
					return new Fulfilled($fulfill_result);
				}catch(\Exception $e){
					return new Rejected($e);
				}
			}
		}else{
			return $this;
		}
	}

} 

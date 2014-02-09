<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

abstract class AbstractPromise implements Promise {

	/**
	 * @param callable $on_reject
	 * @return Promise
	 */
	function trap(callable $on_reject){
		return $this->then(null, $on_reject);
	}

	/**
	 * @param callable $on_finish
	 * @return Promise
	 */
	function end(callable $on_finish){
		return $this->then($on_finish, $on_finish);
	}

} 

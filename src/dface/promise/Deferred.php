<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

/**
 * Special 'top-level' promise. It has methods that resolves a promise explicitly.
 * @package dface\promise
 */
class Deferred extends Link {

	function __construct(){
	}

	function resolve(Promise $promise){
		parent::resolve($promise);
	}

	function fulfill($result = null){
		parent::resolve(new Fulfilled($result));
	}

	function reject($reason = null){
		parent::resolve(new Rejected($reason));
	}

} 

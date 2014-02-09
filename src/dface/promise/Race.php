<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class Race extends CallbackPromise {

	/**
	 * @param Promise[] $promises
	 */
	function __construct($promises = []){
		parent::__construct(function ($fulfill, $reject) use ($promises){
			foreach($promises as $promise){
				$promise->then($fulfill, $reject);
			}
		});
	}

} 

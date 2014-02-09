<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

/**
 * Represents a promise, that fulfills when all of underlying promises get fulfilled.<br><br>
 * On fulfill will contain an array of first all underlying fulfilled results.<br>
 * On reject will contain first underlying rejection reason.<br>
 * @package dface\promise
 */
class All extends CallbackPromise {

	/**
	 * @param Promise[] $promises
	 */
	function __construct($promises = []){
		parent::__construct(function ($fulfill, $reject) use ($promises){
			$results = [];
			$left = count($promises);
			foreach($promises as $i => $promise){
				$promise->then(function($fulfilled_result) use ($i, &$results, &$left, $fulfill){
					$results[$i] = $fulfilled_result;
					$left--;
					if(!$left){
						$fulfill($results);
					}
				}, $reject);
			}
		});
	}

}

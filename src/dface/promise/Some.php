<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

/**
 * Represents a promise, that fulfills when at least N of underlying promises get fulfilled.<br><br>
 * On fulfill will contain an array of first N underlying fulfilled results.<br>
 * On reject will contain an array of first <i>$count - N + 1</i> underlying rejection reasons.<br>
 * @package dface\promise
 */

class Some extends CallbackPromise {

	/**
	 * @param Promise[] $promises tracked promises
	 * @param $amount - how much of them have to be fulfilled to make this promise fulfilled
	 */
	function __construct($promises = [], $amount){
		parent::__construct(function ($fulfill, $reject) use ($promises, $amount){
			$count = count($promises);
			if($count < $amount){
				throw new \InvalidArgumentException("requested amount is more than available");
			}

			$left_fulfills = $amount;
			$left_rejects = $count - $amount + 1;
			$results = [];
			$reasons = [];

			foreach($promises as $i => $promise){
				$promise->then(function($fulfilled_result) use ($i, &$results, &$left_fulfills, $fulfill){
					if($left_fulfills){
						$results[$i] = $fulfilled_result;
						$left_fulfills--;
						if(!$left_fulfills){
							$fulfill($results);
						}
					}
				}, function($reject_reason) use ($i, &$reasons, &$left_rejects, $reject){
					if($left_rejects){
						$reasons[$i] = $reject_reason;
						$left_rejects--;
						if(!$left_rejects){
							$reject($reasons);
						}
					}
				});
			}
		});
	}

} 

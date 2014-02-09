<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

interface Promise {

	/**
	 * @param callable|null $on_fulfill
	 * @param callable|null $on_reject
	 * @return Promise
	 */
	function then(callable $on_fulfill = null, callable $on_reject = null);

	/**
	 * 'catch'
	 * @param callable $on_reject
	 * @return Promise
	 */
	function trap(callable $on_reject);

	/**
	 * @param callable $on_finish
	 * @return Promise
	 */
	function end(callable $on_finish);

}

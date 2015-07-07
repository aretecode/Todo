<?php

namespace Domain\User;

use Domain\Common\UserIdTrait;
use Domain\Common\DataGeneratedTrait;

/**
 * could have UserId as an Invariant, but it is DataGenerated...
 */
class UserEntity {
	use UserIdTrait;
	use DataGeneratedTrait;

	/**
	 * @var boolean
	 *
	 * @see authenticated(), notAuthenticated(), isAuthenticated
	 */
	protected $authenticated = true; 
	protected $status = ""; 
	protected $username = ""; 

	/**
	 * could do setAuthenticated
	 */
	public function authenticated() {
		$this->authenticated = true;
	}
	public function notAuthenticated() {
		$this->authenticated = false;
	}

	/**
	 * @return boolean 
	 */
	public function isAuthenticated() {
		return $this->authenticated;
	}

	/**
	 * @return string 
	 */
	public function getStatus() {
		return $this->status;
	}
}
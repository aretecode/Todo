<?php
	
namespace Domain\Common;

trait UserIdTrait {
	/**
	 * @var mixed(UUID, String, Int)
	 */
	protected $userId;

	/**
	 * @see  $this->userId 
	 */
	public function userId() {
		return $this->userId;
	}
	
	/**
	 * or changeUserId
	 * @param $id
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
	}
}
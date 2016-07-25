<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * @var
	 */
	public $_id;

	/**
	 * @var string
	 */
	public $apiKey;

	/**
	 * @var string
	 */
	public $sessionId;

	/**
	 * UserIdentity constructor.
	 * @param string $apiKey
	 */
	public function __construct($apiKey)
	{
		$this->apiKey = $apiKey;
	}

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$this->sessionId = Yii::app()->mdbApi->setApiKey($this->apiKey)->startGuestSession();
		if ($this->sessionId) {
			$this->setState('sessionId', $this->sessionId);
			$this->setState('apiKey', $this->apiKey);

			$this->errorCode = UserIdentity::ERROR_NONE;
		}

		return true;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->apiKey;
	}

	/**
	 * @return string
	 */
	public function getSessionId()
	{
		return $this->sessionId;
	}
}
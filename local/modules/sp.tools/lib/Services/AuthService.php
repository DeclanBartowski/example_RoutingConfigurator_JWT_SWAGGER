<?php

namespace SP\Tools\Services;

use Bitrix\Main\Engine\ActionFilter\Base;
use Bitrix\Main\Event;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Bitrix\Main\Engine\Controller;

final class AuthService extends Base
{

	private bool $enabled;
	private string $key = 'AURUMEX_JWT_API_PRIVATE_KEY_HS512';
	private string $encryptType = 'HS512';

	/**
	 * Token constructor.
	 *
	 * @param bool $enabled
	 */
	public function __construct(bool $enabled = true)
	{
		$this->enabled = $enabled;
		parent::__construct();
	}

	public function onBeforeAction(Event $event)
	{
		if (!$this->enabled)
		{
			return null;
		}
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			$token = str_replace('Bearer ', '', $headers['Authorization']);
			JWT::decode($token, new Key($this->key, $this->encryptType));
		} else {
			throw new \Exception('You are not authorize');
		}
		return  null;
	}

	/**
	 * @return array
	 */
	public function token()
	{
		$iat = time();
		$exp = $iat + 60 * 60; // Время жизни токена в минутах
		$payload = [
			'iat' => $iat,
			'exp' => $exp,
		];
		$jwt = JWT::encode($payload, $this->key, $this->encryptType);
		return [
			'token' => $jwt,
			'expires' => $exp
		];
	}

}
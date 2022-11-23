<?php

namespace SP\Tools\Controller;

use SP\Tools\Services\AuthService;

/**
 * @OA\SecurityScheme(
 *   type="http",
 *   name="Authorization",
 *   in="header",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 *   description="Ключ полученный методом авторизации",
 *   securityScheme="bearerAuth"
 * )
 */

class AuthController extends \Bitrix\Main\Engine\Controller
{
	/**
	 * @return array
	 */
	public function configureActions()
	{
		return [
			'auth' => [
				'prefilters' => [
				]
			],
		];
	}


	/**
	 * Авторизация
	 *
	 * @param string $login
	 * @param string $password
	 * @return array
	 * @throws \Exception
	 *
	 *  @OA\Post(path="/api/v1/auth",
	 *     tags={"Авторизация"},
	 *     summary="Авторизация",
	 *   @OA\RequestBody(
	 *       required=true,
	 *       @OA\MediaType(
	 *           mediaType="multipart/form-data",
	 *           @OA\Schema(
	 *               type="object",
	 *               @OA\Property(
	 *                  property="login",
	 *                  description="",
	 *                  @OA\Schema(type="string"),
	 *                  example="admin"
	 *               ),
	 *     	          @OA\Property(
	 *                  property="password",
	 *                  description="",
	 *                  @OA\Schema(type="string"),
	 *                  format="password",
	 *                  example="2486200"
	 *               ),
	 *           )
	 *       )
	 *   ),
	 *     @OA\Response(response=200, description="Successful created",
	 *     @OA\MediaType(mediaType="application/json"),
	 *     )
	 * )
	 *
	 *
	 */
	public function authAction(string $login,string $password){
		global $USER,$APPLICATION;
		if (!is_object($USER)) $USER = new \CUser;
		$arAuthResult = $USER->Login($login, $password, "N");
		$APPLICATION->arAuthResult = $arAuthResult;
		if($arAuthResult['TYPE'] == 'ERROR'){
			throw new \Exception($arAuthResult['MESSAGE']);
		}
		else{
			if($token = (new AuthService())->token()){
				return $token;
			}
			else{
				throw new \Exception('Could not create the token for this API. Please contact your administrator');
			}
		}
	}

}
<?php

namespace SP\Tools\Controller;

use Bitrix\Main\Engine\Controller;
use Firebase\JWT\JWT;
use SP\Tools\Services\AuthService;
use Bitrix\Main\Engine\Contract\Controllerable;

/**
 * @OA\Info(title="Aurumex API", version="0.1")
 *
 */
class CatalogController extends Controller 
{

	/**
	 * @return array
	 */
	public function configureActions()
	{
		return [
			'coins' => [
				'prefilters' => [
					new AuthService(),
				]
			],
		];
	}

	/**
	 * Список товаров
	 *
	 * @return array[]
	 * @throws \Exception
	 *
	 *  @OA\Post(path="/api/v1/coins",
	 *     tags={"Каталог"},
	 *     summary="Каталог",
	 *     security={{"bearerAuth":{}}},
	 *   @OA\RequestBody(
	 *       required=true,
	 *       @OA\MediaType(
	 *           mediaType="multipart/form-data",
	 *           @OA\Schema(
	 *               type="object",
	 *               @OA\Property(
	 *                   property="pagination",
	 *                   type="object",
	 *                   description="",
	 *                      @OA\Property(
	 *                       property="page",
	 *                       description="",
	 *                      @OA\Schema(type="integer"),
	 *                      example="1"
	 *                      ),
	 *                      @OA\Property(
	 *                       property="pageSize",
	 *                       description="",
	 *                        @OA\Schema(type="integer"),
	 *                        example="25"
	 *                      ),
	 *               ),
	 *               @OA\Property(
	 *                  property="sort",
	 *                  description="",
	 *                  @OA\Schema(type="string"),
	 *                  example="price-up"
	 *               ),
	 *               @OA\Property(
	 *                   property="filters",
	 *                   type="object",
	 *                   description="",
	 *                      @OA\Property(
	 *                       property="countries",
	 *                       description="",
	 *                       @OA\Schema(type="string"),
	 *                      example="RU"
	 *                      ),
	 *                      @OA\Property(
	 *                       property="weight",
	 *                       description="",
	 *                       @OA\Schema(type="float"),
	 *     example="10"
	 *                      ),
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

	public function coinsAction()
	{
		return  $this->request->getPostList();
	}
}
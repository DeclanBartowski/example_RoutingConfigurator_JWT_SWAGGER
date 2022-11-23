<?php

namespace SP\Tools\Controller;

use Bitrix\Main\Context;

/*
 * @OA\Info(title="Пример документации к API", version="0.1")
 */
class TestController extends \Bitrix\Main\Engine\Controller
{

	/**
	 * @return array
	 */
	public function configureActions()
	{
		return [
			'view' => [
				'prefilters' => []
			],
		];
	}

	/*
	 *
	 * @OA\Post(
	 *     tags={"Категория"},
	 *     summary="Название блока",
	 *     description="Описание блока",
	 *     path="/test",
	 *   @OA\RequestBody(
	 *       required=true,
	 *       @OA\MediaType(
	 *           mediaType="multipart/form-data",
	 *           @OA\Schema(
	 *               required={"integer","string"},
	 *               type="object",
	 *               @OA\Property(
	 *                   property="integer",
	 *                   description="Число",
	 *                   type="integer",
	 *                   example="152467180",
	 *               ),
	 *               @OA\Property(
	 *                   property="string",
	 *                   description="Строка",
	 *                   type="string",
	 *                   example="17660-2"
	 *               ),
	 *          	@OA\Property(property="file", type="string", format="binary"),
	 *              @OA\Property(
	 *                  property="string_arary[]",
	 *                  description="Множественная строка",
	 *                  type="array",
	 *                  @OA\Items(),
	 *                  example={"test","test1"}
	 *              )
	 *           ),
	 *       ),
	 *   ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="Successful operation",
	 *     ),
	 *     )
	 */

	public function viewAction()
	{

		return [
			'$request' => [
				'props' => $this->request->getPostList(),
				'files' => $this->request->getFileList()
			],
		];
	}
}
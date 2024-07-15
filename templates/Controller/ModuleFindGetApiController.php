<?php

declare(strict_types=1);

namespace Seavices\Apps\Backoffice\Backend\Controller\%modules%;

use OpenApi\Annotations as OA;
use Seavices\Backoffice\%modules%\Application\%module%Response;
use Symfony\Component\HttpFoundation\Request;
use Seavices\Shared\Infrastructure\Symfony\ApiResponse;
use Seavices\Shared\Infrastructure\Symfony\ApiController;
use Seavices\Backoffice\%modules%\Application\Find\Find%module%Query;
use Seavices\Backoffice\%modules%\Domain\%module%NotExist;
use Seavices\Shared\Infrastructure\Symfony\ApiResponseProcessCode;
use Seavices\Shared\Infrastructure\Symfony\RequestPermissionsControlException;

final class %module%FindGetApiController extends ApiController
{
    /**
     * Find %module%
     *
     * %module% find by id.
     *
     * @OA\Tag(name="%modules%")
     * 
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     @OA\Schema(
     *         type="string",
     *         format="uuid"
     *     )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Correct creation",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items()
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="array",
     *                 @OA\Items(type="string")
     *             ),
     *             @OA\Property(
     *                 property="timestamp",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="count",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="statuscode",
     *                 type="integer"
     *             )
     *         ),
     *         example={
     *             "data": {},
     *             "message": {
     *                 "Action executed"
     *             },
     *             "timestamp": "2022-09-02 15:08:20",
     *             "count": 1,
     *             "statuscode": 1000,
     *         },
     *     )
     * )
     * 
     * @OA\Response(
     *     response=404,
     *     description="Not Found",
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items()
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="array",
     *                 @OA\Items(type="string")
     *             ),
     *             @OA\Property(
     *                 property="timestamp",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="count",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="statuscode",
     *                 type="integer"
     *             )
     *         ),
     *         example={
     *             "data": {},
     *             "message": {
     *                 "Not Found"
     *             },
     *             "timestamp": "2022-09-02 15:08:20",
     *             "count": 0,
     *             "statuscode": -2000,
     *         },
     *     )
     * )
     * 
     * @OA\Response(
     *     response=500,
     *     description="Internal Server Error",
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items()
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="array",
     *                 @OA\Items(type="string")
     *             ),
     *             @OA\Property(
     *                 property="timestamp",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="count",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="statuscode",
     *                 type="integer"
     *             )
     *         ),
     *         example={
     *             "data": {},
     *             "message": {
     *                 "Internal Server Error"
     *             },
     *             "timestamp": "2022-09-02 15:08:20",
     *             "count": 1,
     *             "statuscode": -5000,
     *         },
     *     )
     * )
     * 
     */

    public function __invoke(Request $request): ApiResponse
    {
        $this->validatePermission('%lowerModules%_list'); 

        return $this->find%module%($request);
    }

    private function find%module%(Request $request): ApiResponse
    {
            /** @var %module%Response $%lowerModule% */
            $%lowerModule% = $this->ask(new Find%module%Query($request->get('id')));
            $%lowerModule%Response = $%lowerModule%->toArray();

            return new ApiResponse(ApiResponseProcessCode::SUCCESS_REQUEST, [$%lowerModule%Response]);
    }

    protected function exceptions(): array
    {
        return [
            ValidationError::class => ApiResponseProcessCode::ERROR_VALIDATION_FAILED,
            %module%NotExist::class => ApiResponseProcessCode::ERROR_NOT_FOUND,
            RequestPermissionsControlException::class => ApiResponseProcessCode::ERROR_AUTHORIZATION
        ];
    }
}

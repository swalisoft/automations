<?php

declare(strict_types=1);

namespace Seavices\Apps\Backoffice\Backend\Controller\%modules%;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Seavices\Shared\Infrastructure\Symfony\ApiResponse;
use Seavices\Shared\Infrastructure\Symfony\ApiController;
use Seavices\Shared\Infrastructure\Symfony\ValidationError;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Seavices\Shared\Infrastructure\Symfony\ApiResponseProcessCode;
use Seavices\Backoffice\%modules%\Application\Update\Update%module%Command;
use Seavices\Backoffice\%modules%\Domain\%module%NotExist;
use Seavices\Shared\Infrastructure\Symfony\AssertRules;
use Seavices\Shared\Infrastructure\Symfony\RequestPermissionsControlException;

final class %module%UpdatePutApiController extends ApiController
{

    /**
     * Update a %lowerModule%
     *
     * Update a %lowerModule%.
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
     * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             @OA\Property(
     *                 property="name",
     *                 type="string"
     *             )
     *         )
     *     )
     * )
     * 
     * @OA\Response(
     *     response=202,
     *     description="Correct update",
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
     *                 "Updated successfully"
     *             },
     *             "timestamp": "2022-09-02 15:08:20",
     *             "count": 0,
     *             "statuscode": 2002,
     *         },
     *     )
     * )
     * 
     * @OA\Response(
     *     response=401,
     *     description="Incorrect update",
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
     *                 "Action not executed"
     *             },
     *             "timestamp": "2022-09-02 15:08:20",
     *             "count": 0,
     *             "statuscode": -4000,
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
        // $this->validatePermission('%lowerModules%_update'); 

        $validationErrors = $this->validateRequest($request);

        $this->validationErrorsProcess($validationErrors);

        return $this->update%module%($request);
    }

    private function validateRequest(Request $request): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection(
            [
                'name'         => [new Assert\NotBlank()],
                'price'        => [new Assert\NotBlank()],
                'tax'          => [new Assert\NotBlank()],
            ]
        );

        $input = $request->request->all();

        return Validation::createValidator()->validate($input, $constraint);
    }

    private function update%module%(Request $request): ApiResponse
    {
        $this->dispatch(
            new Update%module%Command(
                $request->get('id'),
                $request->get('name'),
                $request->get('price'),
                $request->get('tax')
            )
        );

        return new ApiResponse(ApiResponseProcessCode::SUCCESS_UPDATED);
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

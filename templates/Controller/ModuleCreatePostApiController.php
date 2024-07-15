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
use Seavices\Shared\Infrastructure\Symfony\CustomConstrains;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Context\\ExecutionContextInterface;
use Seavices\Shared\Infrastructure\Symfony\ApiResponseProcessCode;
use Seavices\Backoffice\%modules%\Application\Create\Create%module%Command;
use Seavices\Backoffice\%modules%\Application\Find\Find%module%Query;
use Seavices\Shared\Infrastructure\Symfony\RequestPermissionsControlException;

final class %module%CreatePostApiController extends ApiController
{

    /**
     * Create a %lowerModule%
     *
     * Create a %lowerModule%.
     *
     * @OA\Tag(name="%modules%")
     * 
     * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             @OA\Property(
     *                 property="id",
     *                 type="string",
     *                 format="uuid"
     *             ),
     *             @OA\Property(
     *                 property="name",
     *                 type="string"
     *             )
     *         )
     *     )
     * )
     * 
     * @OA\Response(
     *     response=201,
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
     *                 "Created successfully"
     *             },
     *             "timestamp": "2022-09-02 15:08:20",
     *             "count": 1,
     *             "statuscode": 2001,
     *         },
     *     )
     * )
     * 
     * @OA\Response(
     *     response=401,
     *     description="Incorrect creation",
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
        // $this->validatePermission('%lowerModules%_create'); 

        $validationErrors = $this->validateRequest($request);

        $this->validationErrorsProcess($validationErrors);

        return $this->create%module%($request);
    }

    private function validateRequest(Request $request): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection(
            [
                'id'   => [new Assert\NotBlank(), new Assert\Uuid(), new Assert\Callback([
                    $this,
                    '%module%Exist',
                ])],
                'name' => [new Assert\NotBlank()],
            ]
        );

        $input = $request->request->all();

        return Validation::createValidator()->validate($input, $constraint);
    }

    public function %module%Exist($object, ExecutionContextInterface $context, $payload)
    {
        try {
            $this->ask(new Find%module%Query($context->getValue()));
            $context->buildViolation(CustomConstrains::ALREADY_EXISTS)
                ->addViolation();
        } catch (\\Exception $e) {
        }
    }

    private function create%module%(Request $request): ApiResponse
    {
        $this->dispatch(
            new Create%module%Command(
                $request->get('id'),
                $request->get('name'),
            )
        );

        return new ApiResponse(ApiResponseProcessCode::SUCCESS_CREATED);
    }

    protected function exceptions(): array
    {
        return [
            ValidationError::class => ApiResponseProcessCode::ERROR_VALIDATION_FAILED,
            RequestPermissionsControlException::class => ApiResponseProcessCode::ERROR_AUTHORIZATION
        ];
    }
}

<?php

declare(strict_types=1);

namespace Seavices\Apps\Backoffice\Backend\Controller\%modules%;

use OpenApi\Annotations as OA;
use Seavices\Backoffice\Centers\Application\Search\SearchCentersQuery;
use Seavices\Backoffice\%modules%\Application\Delete\Delete%module%Command;
use Seavices\Backoffice\%modules%\Domain\%module%NotExist;
use Seavices\Shared\Infrastructure\Symfony\ApiResponse;
use Seavices\Shared\Infrastructure\Symfony\ApiController;
use Seavices\Shared\Infrastructure\Symfony\ApiResponseProcessCode;
use Seavices\Shared\Infrastructure\Symfony\CustomConstrains;
use Seavices\Shared\Infrastructure\Symfony\RequestPermissionsControlException;
use Seavices\Shared\Infrastructure\Symfony\ValidationError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Context\\ExecutionContextInterface;
use Symfony\Component\Validator\Validation;

final class %module%DeleteDeleteApiController extends ApiController
{
    /**
     * Delete %module%
     *
     * %module% delete by id.
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
        // $this->validatePermission('%lowerModules%_list');

        $validationErrors = $this->validateRequest($request);

        $this->validationErrorsProcess($validationErrors);

        return $this->delete%module%($request);
    }

    private function validateRequest(Request $request): ConstraintViolationListInterface
    {
        $request->request->add(['id' => $request->get('id')]);

        $constraint = new Assert\Collection([
            'id'        => [new Assert\NotBlank(), new Assert\Callback([
                $this,
                'verify%module%',
            ])],
        ]);

        $input = $request->request->all();

        return Validation::createValidator()->validate($input, $constraint);
    }

    private function delete%module%(Request $request): ApiResponse
    {
        $this->dispatch(new Delete%module%Command($request->get('id')));
        return new ApiResponse(ApiResponseProcessCode::SUCCESS_DELETED);
    }

    public function verify%module%($object, ExecutionContextInterface $context, $payload)
    {
        try {
            $centers = $this->ask(new SearchCentersQuery([], null, null, null, null));
            $listCenters = $centers->toArray();
            foreach ($listCenters as &$center) {
                if ($center['%lowerModule%Id'] == $context->getValue()) {

                    $context->buildViolation(CustomConstrains::ENTITY_ASSIGN)
                        ->addViolation();
                }
            }
        } catch (\\Exception $e) {
        }
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

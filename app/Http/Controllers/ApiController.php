<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    protected $statusCode = JsonResponse::HTTP_OK;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondCreated($data = []): JsonResponse
    {
        $this->setStatusCode(JsonResponse::HTTP_CREATED);

        return $this->respond(['data' => $data]);
    }

    public function respondSuccess($data = [], array $meta = []): JsonResponse
    {
        $this->setStatusCode(JsonResponse::HTTP_OK);
        if (!empty($meta)) {
            $content['meta'] = $meta;
        }

        $content['data'] = $data;

        return $this->respond($content);
    }

    public function respondBadRequest($message = 'Bad Request'): JsonResponse
    {
        $this->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);

        return $this->respondError($message);
    }

    public function respondInvalidFilter(): JsonResponse
    {
        return $this->respondBadRequest('Invalid Filter Query');
    }

    public function respondUnauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        $this->setStatusCode(JsonResponse::HTTP_UNAUTHORIZED);

        return $this->respondError($message);
    }

    public function respondNotFound(string $message = 'Not Found'): JsonResponse
    {
        $this->setStatusCode(JsonResponse::HTTP_NOT_FOUND);

        return $this->respondError($message);
    }

    public function respondBusinessLogicError(string $message = ''): JsonResponse
    {
        $this->setStatusCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

        return $this->respondError($message);
    }

    public function respondError($message = ''): JsonResponse
    {
        return $this->respond([
            'error' => [
                'message'     => $message,
                'status_code' => $this->getStatusCode(),
            ],
        ]);
    }

    public function respondErrorValidator(array $errors): JsonResponse
    {
        $this->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);

        return $this->respondError($errors);
    }

    public function respond(array $data = []): JsonResponse
    {
        return response()->json($data, $this->getStatusCode());
    }
}

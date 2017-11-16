<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Validation\Validator;

class ApiController extends Controller
{
    protected $statusCode = Response::HTTP_OK;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondCreated($data = [])
    {
        $content['data'] = $data;

        return $this->setStatusCode(Response::HTTP_CREATED)->respond($content);
    }

    public function respondSuccess($data = [], $meta = [])
    {
        if (!empty($meta)) {
            $content['meta'] = $meta;
        }

        $content['data'] = $data;

        return $this->setStatusCode(Response::HTTP_OK)->respond($content);
    }

    public function respondBadRequest($message = 'Bad Request')
    {
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondError($message);
    }

    public function respondInvalidFilter()
    {
        return $this->respondBadRequest('Invalid Filter Query');
    }

    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondError($message);
    }

    public function respondBusinessLogicError($message = '')
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                    ->respondError($message);
    }

    public function respondError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode(),
            ],
        ]);
    }

    public function respondErrorValidator(array $errors)
    {
        $this->setStatusCode(Response::HTTP_BAD_REQUEST);

        return $this->respondError($errors);
    }

    public function respond($data)
    {
        return response()->json($data, $this->getStatusCode());
    }
}

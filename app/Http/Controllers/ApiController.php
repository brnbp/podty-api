<?php


namespace App\Http\Controllers;



class ApiController extends Controller
{
    protected $statusCode = 200;

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

    public function respondSuccess($data, $meta = [])
    {
        if (!empty($meta)) {
            $content['meta'] = $meta;
        }

        $content['data'] = $data;

        return $this->respond($content);
    }

    public function respondAcceptedRequest()
    {
        return $this->setStatusCode(202)->respond([]);
    }


    public function respondBadRequest($message = 'Bad Request')
    {
        return $this->setStatusCode(400)->respondError($message);
    }

    public function respondInvalidFilter()
    {
        return $this->respondBadRequest('Invalid Filter Query');
    }

    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(404)->respondError($message);
    }

    public function respondError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    public function respond($data)
    {
        return response()->json($data, $this->getStatusCode());
    }

}

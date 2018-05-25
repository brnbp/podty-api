<?php
namespace Tests;

use App\Models\Customer;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function authenticate()
    {
        $this->be(new Customer());
    }

    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct(){}
            public function report(\Exception $e){}
            public function render($request, \Exception $e){
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }
}

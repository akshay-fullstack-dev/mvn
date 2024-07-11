<?php

namespace App\Http\Middleware;

use App\Exceptions\BadRequestException;
use App\Exceptions\BlockedUserException;
use App\Exceptions\InternalServerException;
use App\Exceptions\RecordNotFoundException;
use App\Http\Resources\Interfaces\IHandler;
use App\Traits\APIResponse;
use Exception;
use Illuminate\Auth\AuthenticationException;
use IntersoftStripe\Exceptions\SuccessException;

/**
 *
 * Middleware that tries to automatically transform the data provided
 * that is returned in the form of direct model
 */
class ResourceHandler
{
    use APIResponse;
    private $handler;
    public function __construct(IHandler $handler) //)
    {
        $this->handler = $handler;
    }


    public function handle($request, \Closure $next, $guard = null)
    {
        try {
            $response = $next($request);
            // Having the `original` property means that we have the models and
            // the response can be tried to transform
            if (property_exists($response, 'original')) {
                // Transform based on model and reset the content
                if (is_string($response->original))
                    return $this->reponseSuccess([], $response->original);
                else
                    return $this->reponseSuccess($this->handler->transformModel($response->original));
            }
        } catch (SuccessException $ex) {
            return $this->reponseSuccess($ex->getData(), $ex->getMessage(), $ex->getStatusCode());
        } catch (BlockedUserException $ex) {
            return $this->respondUnauthorized($ex->getMessage());
        } catch (AuthenticationException $ex) {
            return $this->respondUnauthorized();
        } catch (BadRequestException $ex) {
            return $this->respondInvalidParameters($ex->getMessage());
        } catch (RecordNotFoundException $ex) {
            return $this->respondNotFound($ex->getMessage());
        } catch (InternalServerException $ex) {
            return $this->respondInternalError($ex->getMessage());
        } catch (Exception $ex) {
            return $this->respondInternalError($ex->getMessage());
        }
    }


    public function terminate($request, $response)
    {
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        try {

            $user = JWTAuth::parseToken()->authenticate();

        }
        catch (TokenExpiredException $e) {
            return response()->json([
                'message' => 'Token Expired',
                'gsc' => '602'
            ], Response::HTTP_OK);
        }catch (TokenInvalidException $e) {
            return response()->json([
                'message' => 'Invalid Token',
            ], Response::HTTP_OK);
        } catch(JWTException $e) {
            return response()->json([
                'message' => 'Token not found',
            ], Response::HTTP_OK);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
            ], Response::HTTP_OK);
        }
        catch(MethodNotAllowedHttpException $e){

            return response()->json([
                'message' => 'This method is not allowed',
            ], Response::HTTP_OK);
        }
        return $next($request);
    }
}

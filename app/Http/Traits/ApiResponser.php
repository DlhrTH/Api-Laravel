<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{
    function successResponse($data, $code = 200)
    {
        // problemas de paginacion: return response()->json($data, $code);
        if(is_Array($data)){
            if(count($data['data'])) {
                return $data->response()->setStatusCode($code);
            }
        }
        else return $data->response()->setStatusCode($code);
    }
    
    function errorResponse($message, $code)
    {
        return response()->json(['error' => ['message' => $message, 'code' => $code]], $code);
    }

    function showAll($collection, $code = 200)
    {
        // ANTES: return $this->successResponse(['data' => $collection], $code);
		
		if($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }
        
        //si no es una coleccion, no hace falta paginarla porque sera un lengthaware
        if ($collection instanceof Collection) {
            $collection = $this->paginateCollection($collection);
        }
		
        //accedo a la propiedad para conocer la clase transformadora, del 1º elemento
        $resource = $collection->first()->resource;
        
        //accedo al metodo collection de la clase
        $transformedCollection = $resource::collection($collection);
        
        return $this->successResponse($transformedCollection, $code);
    }
    
    function showOne(Model $instance, $code = 200)
    {
        //ANTES: return $this->successResponse(['data' => $instance], $code);
		
		$resource = $instance->resource;
        
        //new UserResource()
        $transformedInstance = new $resource($instance);

        return $this->successResponse($transformedInstance, $code);
    }

    function showMessage($message, $code = 200)
    {
        return $this->successResponse($message, $code);
    }

    function paginateCollection(Collection $collection)
    {
        $perPage = intval($this->determinePageSize());

        $page = intval(LengthAwarePaginator::resolveCurrentPage());

        $results = $collection->forPage($page, $perPage);
        //$results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            ]);

        $paginated->appends(request()->query());

        return $paginated;
    }

    function determinePageSize()
    {
        $rules = [
            'page' => 'integer|min:2|max:50',
        ];

        $perPage = request()->validate($rules);

        return isset($perPage['page'])  ? $perPage : 5;
    }
}
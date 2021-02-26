<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseResource extends JsonResource
{
    public static $map = [];

    public static function mapAttribute($attribute, $invert = false)
    {
        if ($invert) {
            return array_flip(static::$map)[$attribute];
        }
        return static::$map[$attribute];
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        // if(!isset($this->resource)) {
        //     return;
        // }

		$visibleAttributes = $this->resource->attributesToArray();
        $transformedAttributes = [];

        foreach ($visibleAttributes as $attribute => $value) {
            $transformedAttributes[static::mapAttribute($attribute)]= $value;
        }

        //monto las hateoas
        if(method_exists($this, 'generateLinks')) {
            $hateoas = [
                'links' => $this->generateLinks($request),
            ];
            return array_merge($transformedAttributes, $hateoas);        
        }

        return $transformedAttributes;
    }
}
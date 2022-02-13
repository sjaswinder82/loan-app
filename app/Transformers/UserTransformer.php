<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($resource)
    {
        $response = [
            'id' => $resource->id,
            'email' => $resource->email,            
            'name' => $resource->name, 
            'created_at' => $resource->created_at,           
        ];

        if($resource->access_token) { 
            $response['access_token'] = $resource->access_token;
        }

        return $response;
    }
}

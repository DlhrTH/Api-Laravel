<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;
use App\Helpers\Token;

class UserResource extends BaseResource
{
    public static $map = [
        'id' => 'id',
        'name' => 'name',
        'email' => 'email',
        'password' => 'password',
        'confirm_password' => 'confirm_password',
        'updated_at' => 'last_modified',
        'created_at' => 'creation_date',
    ];
    
    public function generateLinks($request)
    {
        return [
            [
                'rel' => 'self',
                'href' => route('users.show', $this->id),
            ],

            [
                'rel' => 'self',
                'href' => route('users.delete', $this->id),
            ],
        ];
    }
	
	public function toArray($request)
    {
		$transformedAttributes = parent::toArray($request);
		
		//inyecto el token, para jwt
        if (isset($request->email_address)) {
			$data_token = [
				"email" => $request->email_address,
			];
			$token = new Token($data_token);
			$token = $token->encode();
			$transformedAttributes['token'] = $token;
		}		
		return $transformedAttributes;

    }
}

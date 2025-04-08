<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'profile_picture' => $this->image_url,
            'username' => $this->username,
            'email' => $this->email,
            'privacy' => $this->privacy_name,
            'gender' => $this->gender_name,
            'is_suspended' => $this->suspendedUser,
            'is_banned' => $this->is_banned
        ];
    }
}

<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    private function flattenPermissions()
    {
        $result = [];
        foreach ($this->permissions as $permission) {
            $result[] = $permission->name;
        }
        return $result;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => Carbon::parse($this->created_at)->format('m/d/Y H:i:s'),
            'permissions' => $this->flattenPermissions(),
        ];
    }
}

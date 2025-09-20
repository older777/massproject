<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $item = [];
        $item['id'] = $this->id;
        $item['price'] = $this->price;
        $item['created_at'] = $this->created_at;
        $item['updated_at'] = $this->updated_at;
        $item['type'] = $this->type;
        $item['preview'] = $this->getFirstMediaUrl('product', 'preview');
        $item['photo'] = $this->getFirstMediaUrl('product');
        switch ($this->type) {
            case 'phones':
                $item['name'] = $this->phone->name;
                $item['model'] = $this->phone->model;
                $item['color'] = $this->phone->color;
                $item['processor'] = $this->phone->processor;
                $item['ram'] = $this->phone->ram;
                $item['storage'] = $this->phone->storage;
                $item['display_size'] = $this->phone->display_size;
                $item['description'] = $this->phone->description;
                break;
            case 'tablets':
                $item['name'] = $this->tablet->name;
                $item['model'] = $this->tablet->model;
                $item['color'] = $this->tablet->color;
                $item['processor'] = $this->tablet->processor;
                $item['ram'] = $this->tablet->ram;
                $item['storage'] = $this->tablet->storage;
                $item['display_size'] = $this->tablet->display_size;
                $item['description'] = $this->tablet->description;
                break;
            case 'parts':
                $item['name'] = $this->part->name;
                $item['model'] = $this->part->model;
                $item['color'] = $this->part->color;
                $item['size'] = $this->part->size;
                $item['weight'] = $this->part->weight;
                $item['description'] = $this->part->description;
                break;
        }

        return $item;
    }
}

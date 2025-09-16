<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Коллекция Product
     * {@inheritDoc}
     *
     * @see \Spatie\MediaLibrary\HasMedia::registerMediaCollections()
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('product')
            ->useFallbackUrl('/storage/nopic.jpeg')
            ->useFallbackPath(storage_path('/app/public/nopic.jpeg'))
            ->useFallbackUrl('/storage/nopic-preview.jpeg', 'preview')
            ->useFallbackPath(storage_path('/app/public/nopic-preview.jpeg'), 'preview');
    }

    /**
     * Конверсия превью
     * {@inheritDoc}
     *
     * @see \Spatie\MediaLibrary\HasMedia::registerMediaConversions()
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 250, 250)
            ->nonQueued();
    }
}

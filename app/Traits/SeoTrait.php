<?php

namespace App\Traits;

use App\Models\Seo;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\JsonLd;
use Carbon\Carbon;
use Illuminate\Support\Str;

trait SeoTrait
{
    public function seoGenerator($item, $defaults = null)
    {
        $seo_item = Seo::query()->where('related', get_class($item))
            ->where('related_id', $item->id)
            ->first();

        SEOMeta::setTitle($seo_item->title ?? $item->title)
            ->setDescription($seo_item->description ?? Str::substr(strip_tags($item->description), 0, 100));

        OpenGraph::setTitle($seo_item->og_title ?? $seo_item->title ?? $item->title)
            ->setDescription($seo_item->og_description ?? $seo_item->description ?? Str::substr(strip_tags($item->description), 0, 100))
            ->setType($seo_item->og_type ?? 'article')
            ->addProperty('locale', $seo_item->locale ?? 'en-US')
            ->addProperty('locale_alternative', $seo_item->locale_alternative ?? 'en-US')
            ->setSiteName($seo_item->og_sitename ?? env('APP_NAME'))
            ->setArticle([
                'published_time' => Carbon::parse($item->created_at)->toW3cString(),
                'modified_time' => Carbon::parse($item->updated_at)->toW3cString(),
                'author' => 'QBookBD'
//                'section' => 'string',
//                'tag' => 'string / array'
            ]);

        JsonLd::setTitle($seo_item->og_title ?? $seo_item->title ?? $item->title)
            ->setDescription($seo_item->og_description ?? $seo_item->description ?? Str::substr(strip_tags($item->description), 0, 100))
            ->setType($seo_item->og_type ?? 'article');

        if ($item->photo) {
            OpenGraph::addImage(filter_var($item->photo, FILTER_VALIDATE_URL) ? $item->photo : asset('storage/'.$item->photo), [
                "width" => 300,
                "height" => 200
            ]);
            JsonLd::addImage(filter_var($item->photo, FILTER_VALIDATE_URL) ? $item->photo : asset('storage/'.$item->photo));
        } elseif ($item->thumbnail) {
            OpenGraph::addImage(filter_var($item->thumbnail, FILTER_VALIDATE_URL) ? $item->thumbnail : asset('storage/'.$item->thumbnail), [
                "width" => 300,
                "height" => 200
            ]);
            JsonLd::addImage(filter_var($item->thumbnail, FILTER_VALIDATE_URL) ? $item->thumbnail : asset('storage/'.$item->thumbnail));
        }
        OpenGraph::setUrl($seo_item->og_url ?? request()->url());

        if ($seo_item) {
            if ($seo_item->canonical) {
                SEOMeta::setCanonical($seo_item->canonical);
            }
            if ($seo_item->keywords) {
                SEOMeta::setKeywords($seo_item->keywords);
            }
            foreach ($seo_item->images as $image) {
                OpenGraph::addImage(filter_var($image->src, FILTER_VALIDATE_URL) ? $item->src : url($item->src), [
                    "width" => $image->width ?? 300,
                    "height" => $image->height ?? 200
                ]);
                JsonLd::addImage(filter_var($image->src, FILTER_VALIDATE_URL) ? $item->src : url($item->src));
            }
        }
    }

    public function setSeoFields($item, $seo_fields)
    {
        if (!$item || !$seo_fields) {
            return false;
        }
        $seo = Seo::query()->firstOrNew([
            "related" => get_class($item),
            "related_id" => $item->id
        ]);

        $seo->title = isset($seo_fields['title']) ? $seo_fields['title'] : null;
        $seo->description = isset($seo_fields['description']) ? $seo_fields['description'] : null;
        $seo->canonical = isset($seo_fields['canonical']) ? $seo_fields['canonical'] : null;
        $seo->keywords = isset($seo_fields['keywords']) ? $seo_fields['keywords'] : null;
        $seo->og_url = isset($seo_fields['og_url']) ? $seo_fields['og_url'] : null;
        $seo->og_title = isset($seo_fields['og_title']) ? $seo_fields['og_title'] : null;
        $seo->og_description = isset($seo_fields['og_description']) ? $seo_fields['og_description'] : null;
        $seo->og_type = isset($seo_fields['og_type']) ? $seo_fields['og_type'] : null;
        $seo->og_locale = isset($seo_fields['og_locale']) ? $seo_fields['og_locale'] : null;
        $seo->og_locale_alternative = isset($seo_fields['og_locale_alternative']) ? $seo_fields['og_locale_alternative'] : null;
        $seo->og_sitename = isset($seo_fields['og_sitename']) ? $seo_fields['og_sitename'] : null;


        $seo->save();
    }
}



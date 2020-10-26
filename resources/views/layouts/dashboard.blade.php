<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{_s('site_name','Wovo Soft')}}</title>
    <base href="{{url("/")}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="stylesheet" href="{{mix("css/app.css")}}">
    <script>
        function listLanguages() {
            return <?php echo json_encode($list_languages); ?>;
        }

        function _u(key, fallback) {
            if (!fallback) {
                fallback = key;
            }
            const u =<?php echo json_encode(auth()->user()->only('name'))?>;
            if (!key) {
                return u;
            }
            return (typeof u[key] !== "undefined") ? u[key] : fallback;
        }

        function _s(key, fallback) {
            if (!fallback) {
                fallback = key;
            }

            const s = <?php echo json_encode(config('the_settings')->only('site_name', 'currency', 'locale', 'language')) ?>;
            if (!key) {
                return s;
            }
            return (typeof s[key] !== "undefined") ? s[key] : fallback;
        }

        var translation_collector = null;


        function _t(key, fallback) {
            // const TRANSLATION_COLLECTOR_ENABLED = true;
            if (!fallback) {
                fallback = key;
            }

                @if(app()->environment('production'))
            const t =@php echo json_encode(currentLangTranslations());@endphp;
                @else
                @php
                    $local_trans = json_decode(\Illuminate\Support\Facades\File::get(resource_path("lang/full.json")));
                    $tt = [];
                    foreach ($local_trans as $key => $value) {
                        $tt[$key] = $value->bn;
                    }
                @endphp
            const t =<?php echo json_encode($tt);?>;
            @endif

            // if (!translation_collector) {
            //     translation_collector = t;
            // }
            // if (TRANSLATION_COLLECTOR_ENABLED && !(key in translation_collector)) {
            //     translation_collector[key] = fallback;
            //     console.log(Object.keys(translation_collector).length)
            // }
            if (!key) {
                return t;
            }

            return (typeof t[key] !== "undefined") ? t[key] : fallback;
        }
    </script>
    @routes
    <script defer src="{{ mix('js/app.js') }}"></script>
</head>
<body class="h-100" style="overflow-x: hidden;">
<div id="app"></div>

{{--{!!--}}
{{--    ssr('js/app-server.js')--}}
{{--    ->fallback('<div id="app"></div>')--}}
{{--    ->render()--}}
{{--!!}--}}

<form id="logout-form" style="display: none" method="post" action="{{route('logout')}}">@csrf</form>
</body>
</html>

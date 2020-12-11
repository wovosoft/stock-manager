<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{_s('site_name','Wovo Soft')}}</title>
    <base href="{{url("/")}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{mix("css/app.css")}}">
    <script>
        function listLanguages() {
            return @json($list_languages);
        }

        function _u(key, fallback) {
            if (!fallback) {
                fallback = key;
            }
            const u =@json(auth()->user()->only('name'));
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

        {{--var translation_collector = null;--}}

        function _t(key, fallback) {
            // const TRANSLATION_COLLECTOR_ENABLED = true;
            if (!fallback) {
                fallback = key;
            }
            const t = @json($translations);
            {{--
             if (!translation_collector) {
                translation_collector = t;
            }
            if (TRANSLATION_COLLECTOR_ENABLED && !(key in translation_collector)) {
                translation_collector[key] = fallback;
                console.log(Object.keys(translation_collector).length)
            }
            --}}
            if (!key) {
                return t;
            }
            return (typeof t[key] !== "undefined") ? t[key] : fallback;
        }
    </script>
    @routes('Backend')
    <script defer src="{{ mix('js/app.js') }}"></script>
</head>
<body class="h-100" style="overflow-x: hidden;">
<form id="logout-form" style="display: none" method="post" action="{{route('logout')}}">@csrf</form>
<div id="app"></div>
</body>
</html>

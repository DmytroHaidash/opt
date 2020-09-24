<div id="map" class="h-64 mt-8 rounded overflow-hidden"></div>

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css"/>
@endpush

@push('scripts')
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>

    <script>
        const platform = new H.service.Platform({
            'apikey': '{{ config("services.herewego.key") }}'
        });

        const defaultLayers = platform.createDefaultLayers();

        const map = new H.Map(
            document.getElementById('map'),
            defaultLayers.vector.normal.map,
            {
                zoom: 17,
                center: {
                    lat: {{ $product->latitude }},
                    lng: {{ $product->longitude }}
                }
            });

        const mapEvents = new H.mapevents.MapEvents(map);
        var behavior = new H.mapevents.Behavior(mapEvents);

        const svgMarkup = '<svg viewBox="-34 0 512 512" width="20" height="20" xmlns="http://www.w3.org/2000/svg"><path d="m378.207031 64.890625c-41.84375-41.84375-97.480469-64.890625-156.65625-64.890625-59.179687 0-114.816406 23.046875-156.660156 64.890625s-64.890625 97.480469-64.890625 156.65625c0 59.179687 23.046875 114.816406 64.890625 156.660156l117.703125 117.707031c10.375 10.375 24.207031 16.085938 38.953125 16.085938 14.742187 0 28.578125-5.710938 38.949219-16.085938l117.710937-117.707031c41.847657-41.84375 64.890625-97.480469 64.890625-156.660156 0-59.175781-23.046875-114.8125-64.890625-156.65625zm-156.65625 205.925781c-27.167969 0-49.269531-22.101562-49.269531-49.269531 0-27.164063 22.101562-49.265625 49.269531-49.265625 27.164063 0 49.265625 22.101562 49.265625 49.265625 0 27.167969-22.101562 49.269531-49.265625 49.269531zm0 0" fill="#ff4949"/><path d="m378.207031 64.890625c-41.84375-41.84375-97.480469-64.890625-156.65625-64.890625v172.28125c27.164063 0 49.265625 22.101562 49.265625 49.269531 0 27.164063-22.101562 49.265625-49.265625 49.265625v241.183594c14.742188 0 28.574219-5.714844 38.945313-16.085938l117.710937-117.707031c41.847657-41.84375 64.890625-97.480469 64.890625-156.660156 0-59.175781-23.046875-114.8125-64.890625-156.65625zm0 0" fill="#f30051"/></svg>';

        let icon = new H.map.Icon(svgMarkup),
            coords = {
                lat: {{ $product->latitude }},
                lng: {{ $product->longitude }}
            },
            marker = new H.map.Marker(coords, {icon: icon});

        map.addObject(marker);
        map.setCenter(coords);

        H.ui.UI.createDefault(map, defaultLayers, 'ru-RU');
    </script>
@endpush

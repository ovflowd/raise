<script src="@path/assets/js/vendor/jquery.min.js"></script>
<script src="@path/assets/js/vendor/foundation.min.js"></script>
<script src="@path/assets/js/app/app.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5gvbBwjxzULb1boIMYXMopQEwSdn4Uw4"></script>
<script src="@path/assets/js/vendor/moment.min.js"></script>
<script src="@path/assets/js/vendor/chart.min.js"></script>
<script src="@path/assets/js/app/client.scripts.min.js"></script>
<script>
    jQuery(document).ready(function () {
        createMap({lat: {{$latitude or '0.0'}}, lng: {{$longitude or '0.0'}}});

        createChart(document.getElementById('client_data').getContext('2d'), {!! json_encode($data) !!});
    });
</script>

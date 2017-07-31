<script src="@path/assets/js/vendor/jquery.js"></script>
<script src="@path/assets/js/vendor/foundation.min.js"></script>
<script src="@path/assets/js/app/app.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5gvbBwjxzULb1boIMYXMopQEwSdn4Uw4"></script>
<script src="@path/assets/js/vendor/moment.min.js"></script>
<script src="@path/assets/js/vendor/chart.min.js"></script>
<script src="@path/assets/js/app/client.scripts.js"></script>
<script>
    jQuery(document).ready(function () {
        createMap({lat: {{$latitude}}, lng: {{$longitude}}});

        createChart(document.getElementById('client_data').getContext('2d'), {!! json_encode($data) !!});
    });
</script>
<script src="/assets/js/vendor/jquery.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5gvbBwjxzULb1boIMYXMopQEwSdn4Uw4"></script>
<script>
    jQuery(document).ready(function () {
        var clientPosition = {lat: {{$latitude}}, lng: {{$longitude}}};

        var googleMap = new google.maps.Map(document.getElementById('map_canvas'), {
            center: clientPosition,
            zoom: 8,
            mapTypeId: 'roadmap',
            mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
        });

        new google.maps.Marker({
            position: clientPosition,
            map: googleMap
        });
    })
</script>
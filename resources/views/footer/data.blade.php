<script src="@path/assets/js/vendor/jquery.min.js"></script>
<script src="@path/assets/js/vendor/foundation.min.js"></script>
<script src="@path/assets/js/app/app.min.js"></script>
<script src="@path/assets/js/vendor/moment.min.js"></script>
<script src="@path/assets/js/vendor/chart.min.js"></script>
<script src="@path/assets/js/vendor/hammer.min.js"></script>
<script src="@path/assets/js/vendor/chart.zoom.min.js"></script>
<script src="@path/assets/js/app/data.scripts.js"></script>
<script src="@path/assets/js/vendor/list.min.js"></script>
<script>
    jQuery(document).ready(function () {
        new List('list-data', {
            valueNames: [{name: 'data-values', attr: 'value'}, 'data-date'],
            listClass: 'list',
            searchClass: 'data-search',
            page: 5,
            pagination: true
        });

        createChart(document.getElementById('service_data').getContext('2d'), {!! json_encode($graph) !!});
    })
</script>

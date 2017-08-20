<script src="@path/assets/js/vendor/jquery.min.js"></script>
<script src="@path/assets/js/vendor/foundation.min.js"></script>
<script src="@path/assets/js/app/app.min.js"></script>
<script src="@path/assets/js/vendor/list.min.js"></script>
<script>
    jQuery(document).ready(function () {
        new List('list-clients', {
            valueNames: ['client-name', {name: 'client-tags', attr: 'value'}, 'client-date'],
            listClass: 'list',
            searchClass: 'client-search',
            page: 5,
            pagination: true
        });
        new List('list-logs', {
            valueNames: ['log-date', 'log-type'],
            listClass: 'list',
            searchClass: 'log-search',
            page: 5,
            pagination: true
        });
    })
</script>

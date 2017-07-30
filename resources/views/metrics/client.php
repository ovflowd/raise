<div class="grid-container" style="margin: 50px 0;">
    <div class="grid-x grid-padding-x">
        <div class="large-6 medium-6 small-12 cell">
            <h2 class="title"><?= $client->name ?></h2>
            <pre class="see" style="margin-left:20px">[ <?= empty($client->tags) ? 'No Tags' :
                    implode(', ', $client->tags) ?> ]</pre>
            <br>
            <div class="callout warning" style="margin-left:20px">
                <b>Chipset:</b> <?= $client->chipset ?><br>
                <b>Mac Address:</b> <?= $client->mac ?><br>
                <b>Channel:</b> <?= $client->channel ?><br>
                <b>Processor:</b> <?= $client->processor ?><br>
            </div>
            <div class="callout primary" style="margin-left:20px;">
                <canvas id="client_data" width="auto" height="150"></canvas>
            </div>
        </div>
        <div class="large-6 medium-6 small-12 cell">
            <b>Location</b>
            <span class="see">You can see the location of the client above.</span>
            <div id="map_canvas" style="width: auto; height: 100px;border-radius:4px;"></div>
            <br>
            <b>Services</b>
            <span class="see">You can list the <b>client</b> services on the table above.</span>
            <div style="margin-top:0" class="callout table">
                <h4>List Services</h4>

                <ul style="margin: 20px;list-style: none;">
                    <?php if (empty($services)) {
                        return;
                    }

                    foreach ($services as $service):
                        echo "<li><div class='callout primary'>".
                            "<a href='/view/client/{$service->id}/data' style='float:right' class='see-button'>Watch</a>".
                            "<h5 style='margin-bottom:0'>{$service->document->name}</h5>".
                            "<small>[ ID: {$service->id} ]</small></div></li>";
                    endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="/assets/js/vendor/moment.min.js"></script>
<script src="/assets/js/vendor/Chart.min.js"></script>
<script>
    var ctx = document.getElementById("client_data").getContext("2d");

    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };

    var color = Chart.helpers.color;

    function date(unix) {
        return moment.unix(unix).format('MM/DD/YYYY HH::mm');
    }

    var data = <?= json_encode(array_map(function ($service) {
                        $dataSet = new \stdClass();
                        $dataSet->label = $service->document->name;
                        $dataSet->data = [];
                        $dataSet->fill = true;

                        $query = new Koine\QueryBuilder\Statements\Select();
                        $query->where('serviceId', $service->id);
                        $query->limit(30);

                        $amount = 0;

                        foreach (database()->select('data', $query) as $data):
            $dataSet->data[] = ['x' => $data->document->clientTime, 'y' => ++$amount];
                        endforeach;

                        return $dataSet;
                    }, $services)); ?>;

    var colorNames = Object.keys(window.chartColors);

    jQuery.each(data, function (key, value) {
        jQuery.each(value.data, function (dataKey, dataValue) {
            dataValue.x = date(dataValue.x);
        });

        var colorName = colorNames[(Math.floor(Math.random() * 10) + 1) % colorNames.length];
        var newColor = window.chartColors[colorName];

        value.backgroundColor = color(newColor).alpha(0.5).rgbString();
        value.borderColor = newColor;
    });

    var config = {
        type: 'line',
        data:  {
            datasets: data
        },
        options: {
            responsive: true,
            title:{
                display:true,
                text: "Last Data in Client Service"
            },
            scales: {
                xAxes: [{
                    type: "time",
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Date'
                    },
                    gridLines : {
                        display : false
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Amount'
                    },
                    gridLines : {
                        display : false
                    }
                }]
            }
        }
    };

    window.myLine = new Chart(ctx, config);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5gvbBwjxzULb1boIMYXMopQEwSdn4Uw4&sensor=false">
</script>
<script>
    jQuery(document).ready(function () {
        map = new google.maps.Map(document.getElementById('map_canvas'), {
            center: new google.maps.LatLng(<?= explode(':', $client->location)[0] ?>,<?= explode(':', $client->location)[1] ?>),
            zoom: 8,
            mapTypeId: 'roadmap',
            mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
        });
    })
</script>
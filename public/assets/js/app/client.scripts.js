/**
 * Create a Google Map with Marker
 * @param position
 * @returns {google.maps.Map}
 */
function createMap(position) {
    var googleMap = new google.maps.Map(document.getElementById('map_canvas'), {
        center: position,
        zoom: 8,
        mapTypeId: 'roadmap',
        mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
    });

    new google.maps.Marker({
        position: position,
        map: googleMap
    });

    return googleMap;
}

function createChart(data) {
    var config = {
        type: 'line',
        data: {
            datasets: [{
                label: "Service One",
                data: [{
                    x: 0,
                    y: 0
                }],
                fill: true
            }]
        },
        options: {
            responsive: true,
            title: {
                display: false,
                text: ""
            },
            scales: {
                xAxes: [{
                    type: "time",
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Date Registered'
                    },
                    gridLines: {
                        display:false
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Amount of Data'
                    },
                    gridLines: {
                        display:false
                    }
                }]
            }
        }
    };
}



window.chartColors = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: 'rgb(54, 162, 235)',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(201, 203, 207)'
};

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

function createChart(context, data) {
    var timeFormat = 'MM/DD/YYYY HH:mm', color = Chart.helpers.color, colorNames = Object.keys(window.chartColors);

    var dataSet = jQuery.each(data, function (index, value) {
        var random = Math.floor(Math.random() * 8) + 1,
            newColor = window.chartColors[colorNames[random % colorNames.length]];

        value.borderColor = newColor;
        value.backgroundColor = color(newColor).alpha(0.5).rgbString();

        jQuery.each(value.data, function (item, element) {
            element.x = moment(element.x).format(timeFormat);
        });
    });

    var config = {
        type: 'line',
        data: {datasets: dataSet},
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

    window.myLine = new Chart(context, config);
}



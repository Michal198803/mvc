document.addEventListener('DOMContentLoaded', function () {
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    let tab = [];
    tab.push(['Task', 'Hours per Day']);
    fetch('ToJson')
        .then(function (response) {
            return response.json();
        })
        .then(function (obj) {
            console.log(obj);
            for (let i in obj) {
                tab.push([obj[i].name, parseFloat(obj[i].count)]);
            }
        }).catch(function (error) {
        console.error('JSON import error');
    });

// Draw the chart and set the chart values
    function drawChart() {
        let data = google.visualization.arrayToDataTable(tab);

        // Optional; add a title and set the width, height of the chart
        let options = {'title': 'Expenses chart', 'width': 550, 'height': 400, 'pieHole': 0.3};

        // Display the chart inside the <div> element with id="piechart"
        let chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
}, false);
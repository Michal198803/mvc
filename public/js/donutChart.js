var tab;
var chart;
var data;
var options;
document.addEventListener('DOMContentLoaded', function () {
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    tab = [];
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


    function drawChart() {
        data = google.visualization.arrayToDataTable(tab);
        options = {'title': 'Expenses chart', 'width': 550, 'height': 400, 'pieHole': 0.3};

        chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
}, false);

function reloadChart() {
    $(document).ready(function () {
        tab = [];
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
        }).then(function () {
            data = google.visualization.arrayToDataTable(tab);
            options = {'title': 'Expenses chart', 'width': 550, 'height': 400, 'pieHole': 0.3};
            chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        });

    })
}
$(function () {
    var ctx = document.getElementById("myChart").getContext("2d");
    // examine example_data.json for expected response data
    var json_url = "example_data.json";

    // draw empty chart
    var myChart = new Chart(ctx, {
        type: 'line',
        data:
        {
            labels: [],
            datasets: [
                {
                    label: "Sales",
                    fill: false,
                          lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,

                    data: [],
                    spanGaps: false,
                },

                {
                    label: "Purchase",
                    fill: false,
                    lineTension: 0.3,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    //pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10, 
                    data: [],
                    spanGaps: false,
                },

            ]
        },





        options: {
            tooltips: {
                mode: 'index',
                intersect: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });

    ajax_chart(myChart, "inventory/getsaleschart");

    // function to update our chart
    function ajax_chart(chart, url, data) {
        var data = data || {};

        $.getJSON(url, data).done(function(response) {
            console.log(response);
            chart.data.labels = response.labels;
            chart.data.datasets[0].data = response.data.sales; // or you can iterate for multiple datasets
            chart.data.datasets[1].data = response.data.purchase;
            //chart.data[1].datasets[0].data = response.data.quantity; // or you can iterate for multiple datasets

            chart.update(); // finally update our chart
        });
    }
});

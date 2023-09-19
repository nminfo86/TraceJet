function buildTable(list) {
    return table.DataTable({
        data: list,
        columns: [
            {
                title: "SN",
                data: "serial_number",
            },
            {
                title: "status",
                data: "result",
                render: function (data) {
                    if (data == "NOK") {
                        return `<label class="badge bg-danger">${data}</label>`;
                    } else return `<label class="badge bg-success">OK</label>`;
                },
            },
            {
                title: "time",
                data: "updated_at",
            },
        ],
        searching: false,
        bLengthChange: false,
        destroy: true,
        order: [1, "desc"],
    });
}

function buildChart(of_ok, of_quantity, labels) {
    let x = parseInt(of_ok) / parseInt(of_quantity);

    percent = Math.floor(x * 100);

    $("#percent").text(percent + " %");
    let rest = 0;
    if (percent < 100) {
        rest = 100 - percent;
    }
    newPercent = [percent, rest];
    var options1 = {
        type: "doughnut",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "# of Votes",
                    data: [percent, rest],
                    backgroundColor: ["rgba(46, 204, 113, 1)"],
                    borderColor: ["rgba(255, 255, 255 ,1)"],
                    borderWidth: 5,
                },
            ],
        },
        options: {
            rotation: 1 * Math.PI,
            circumference: 1 * Math.PI,
            legend: {
                display: false,
            },
            tooltip: {
                enabled: false,
            },
            cutoutPercentage: 85,
        },
    };
    var ctx1 = document.getElementById("chartJSContainer").getContext("2d");
    var chart1 = new Chart(ctx1, options1);
}

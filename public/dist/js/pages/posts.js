function buildTable(list) {
    return table.DataTable({
        data: list,
        columns: [
            {
                // title: "SN",
                data: "serial_number",
            },
            {
                // title: "status",
                data: "result",
                render: function (data) {
                    if (data == "NOK") {
                        return `<label class="badge bg-danger">${data}</label>`;
                    } else return `<label class="badge bg-success">OK</label>`;
                },
            },
            {
                // title: "time",
                data: "updated_at",
            },
        ],
        searching: false,
        bLengthChange: false,
        destroy: true,
        order: [0, "desc"],
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

function printBoxTicket(box_ticket) {
    console.log(box_ticket);
    alert(box_ticket.company.box_qr);
    //serial_numbers = box_ticket.serial_numbers
    var sn = "";
    box_ticket.serial_numbers.forEach((element) => {
        sn += `<p>${element}</p>`;
    });
    $("#qr_code").html("");
    const pElement = document.getElementById("qr_code");
    var qr = new QRCode(pElement, {
        text: box_ticket.company.box_qr,
        width: 50,
        height: 50,
    });
    var canvas = $("#qr_code canvas");
    // console.log(canvas);
    var img = canvas.get(0).toDataURL("image/png");
    var newWin = window.open("", "PRINT", "height=700,width=1200");
    newWin.document.write(`<!DOCTYPE html>
                <html>
                <head>
                    <style>
                        @page {
                            size: "a6";
                            margin: 0px;
                        }
                        .flex-container {
                            display: flex;
                        }
                        .flex-between {
                            display: flex;
                            justify-content: space-between;
                            padding-inline: 10px;
                        }
                        table,
                        th,
                        td {
                            border: 1px solid black;
                            border-collapse: collapse;
                        }
                        tr {
                            padding-top: 1px;
                            padding-bottom: 1px;
                        }
                        p {
                            display: block;
                            margin-block-start: 0.2em;
                            margin-block-end: 0.2em;
                            margin-inline-start: 0px;
                            margin-inline-end: 0px;
                        }
                        .sn  p {
                            padding: 3px;
                            border: 1px solid grey;
                            border-radius: 10px;
                        }
                    </style>
                </head>
                <body >
                        <div class="company-header">
                            <div class="flex-container">
                                <img src="${box_ticket.company.logo}" alt="Company Logo">
                                <div style="margin-inline: auto">
                                    <h3>${box_ticket.company.name}</h3>
                                    <p style="text-align:center"> ${box_ticket.company.name} </p>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="flex-between">
                            <p>Nom de produit</p>
                            <h3>${box_ticket.company.product}</h3>
                            <p>اسم المنتج</p>
                        </div>
                        <table width="100%">
                            <tr>
                                <th style="width:90%;">
                                        <span style="font-size:12px">CARTON N°</span>
                                        <span style="font-size:12px">${box_ticket.company.box_qr}</span>
                                        <span style="font-size:12px">رقم التعليب</span>
                                </th>
                                <th style="width:15%">
                                    <img src="${img}" style="padding:10px"/>
                                    </th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="flex-between">
                                        <p>N° DE SERIE</p>
                                        <p>الارقام التسلسلية</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="flex-between sn">
                                        ${sn}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="flex-between" style="margin: 0px">
                                        <p>${box_ticket.company.boxed_date}</p>
                                        <p style="border-inline-start:1px solid; padding-inline-start: 5px"> Qté ${box_ticket.company.box_quantity} الكمية</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                </body>
                </html>
                         `);
    newWin.document.close();
    // Wait for the new window to load the content
    newWin.onload = function () {
        newWin.print();
        newWin.close();
    };
}

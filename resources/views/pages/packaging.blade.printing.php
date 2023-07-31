<style>
    .a6-size-div {
        width: 105mm;
        /* You can use "px", "in", or other relevant units */
        height: 148mm;
        border: 1px solid black;
        /* For visualization purposes, add a border */
        /* background-color: lightgray; */
        /* For visualization purposes, add a background color */
        padding-inline: 10px;
    }

    .flex-container {
        display: flex;

        /* flex-wrap: nowrap; */
        /* background-color: DodgerBlue; */
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

    /* .sn div:not(:first-child) {
        padding-inline-start: 7px;
        border-inline-start: 1px solid;
    } */

    .sn div p {
        padding: 3px;
        border: 1px solid grey;
        border-radius: 10px;
    }
</style>
<!--==============================================================-->
<!-- End PAge Content -->
<!-- ============================================================== -->
<div class="a6-size-div">
    <div class="company-header">
        <div class="flex-container">
            {{-- <div style="background-color: darkcyan"> --}}
            <img src="company-logo.png" alt="Company Logo">
            {{-- </div> --}}
            <div style="margin-inline: auto">
                <h3>Company Name</h3>
                <p style="text-align:center"> EN. AMC </p>
            </div>
        </div>
    </div>
    <hr />
    <div class="flex-between">
        <p>Nom de produit</p>
        <p>Nom de produit</p>
        <p>اسم المنتج</p>
    </div>
    <table width="100%">
        <tr>
            <th style="width:85%">
                <div class="flex-between">
                    <p>carton N</p>
                    <p>1111111111111111</p>
                    <p>رقم التعليب</p>
                </div>
            </th>
            <th style="width:15%">
                QR</th>
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
                    <div>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                    </div>
                    <div>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                    </div>
                    <div>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                    </div>
                    <div>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                    </div>
                    <div>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                    </div>
                    <div>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                    </div>
                    <div>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                    </div>
                    <div>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                        <p>
                            001
                        </p>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="flex-between" style="margin: 0px">
                    <p>DATE 2022-10-sdf</p>
                    <p style="border-inline-start:1px solid; padding-inline-start: 5px"> Qté 45 الكمية</p>
                </div>
            </td>
        </tr>
    </table>
    <!-- Your content goes here -->
</div>
@push('custom_js')
    <script type="text/javascript"></script>
@endpush

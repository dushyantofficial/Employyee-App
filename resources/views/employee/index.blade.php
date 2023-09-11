<!DOCTYPE html>
<html>
<style>
    /*
        Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
        */

    body {
        counter-reset: my-sec-counter;
        font-family: 'Open Sans', sans-serif;
        font-size: 12px;
    }

    #DataTable {
        position: relative;
        padding: 15px;
        box-sizing: border-box;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #333;
        color: white;
        font-weight: bold;
        cursor: cell;
    }

    td, th {
        padding: 6px;
        border: 1px solid #ccc;
        text-align: left;
        box-sizing: border-box;
    }

    tr:nth-of-type(odd) {
        background: #eee;
    }

    @media only screen
    and (max-width: 760px), (min-device-width: 768px)
    and (max-device-width: 1024px) {

        table {
            margin-top: 106px;
        }

        /* Force table to not be like tables anymore */
        table, thead, tbody, th, td, tr {
            display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        tr {
            margin: 0 0 1rem 0;
            overflow: auto;
            border-bottom: 1px solid #ccc;
        }


        tbody tr:before {
            counter-increment: my-sec-counter;
            content: "";
            background-color: #333;
            display: block;
            height: 1px;
        }


        tr:nth-child(odd) {
            background: #ccc;
        }

        td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            margin-right: 0%;
            display: block;
            border-right: 1px solid #ccc;
            border-left: 1px solid #ccc;
            box-sizing: border-box;
        }

        td:before {
            /* Top/left values mimic padding */
            font-weight: bold;
            width: 50%;
            float: left;
            box-sizing: border-box;
            padding-left: 5px;
        }

        /*
        Label the data
    You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
        */
        td:nth-of-type(1):before {
            content: "Campaign Name";
        }

        td:nth-of-type(2):before {
            content: "Start Date";
        }

        td:nth-of-type(3):before {
            content: "End Date";
        }

        td:nth-of-type(4):before {
            content: "Action";
        }

        .box ul.pagination {
            position: relative !important;
            bottom: auto !important;
            right: auto !important;
            display: block !important;
            width: 100%;
        }

        .box {
            text-align: center;
            position: fixed;
            width: 100%;
            background-color: #fff;
            top: 0px;
            left: 0px;
            padding: 15px;
            box-sizing: border-box;
            border-bottom: 1px solid #ccc;
        }

        .box ul.pagination {
            display: block;
            margin: 0px;
        }

        .box .dvrecords {
            display: block;
            margin-bottom: 10px;
        }

        .pagination > li {
            display: inline-block;
        }
    }

    .top-filters {
        font-size: 0px;
    }

    .search-field {
        text-align: right;
        margin-bottom: 5px;
    }

    .dd-number-of-recoeds {
        font-size: 12px;
    }

    .search-field,
    .dd-number-of-recoeds {
        display: inline-block;
        width: 50%;
    }

    .box ul.pagination {
        position: absolute;
        bottom: -45px;
        right: 15px;
    }

    .box .dvrecords {
        padding: 5px 0;
    }

    .box .dvrecords .records {
        margin-right: 5px;
    }
    .input_desing {
        height: calc(2.25rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
</style>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"
          integrity="sha512-rqQltXRuHxtPWhktpAZxLHUVJ3Eombn3hvk9PHjV/N5DMUYnzKPC1i3ub0mEXgFzsaZNeJcoE0YHq0j/GFsdGg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
@include('flash-message')
<div class="container">
    <!--    <h2>Simple Pagination Example using Datatables Js Library</h2>-->
    <br>
    <div class="row mb-3 d-flex">

        <div class="col-8">
            <form id="date_filter" action="{{route('get-employee')}}" method="get">
                @csrf
                <input type="date" id="start_date" class="input_desing" name="start_date" value="{{old('start_date')}}">
                <input type="date" id="end_date" class="input_desing" name="end_date" value="{{old('end_date')}}">
                <button class="btn btn-primary me-md-2"><i class="fas fa-filter"></i></button>
                <button id="reset" class="btn btn-dark me-md-2"><i class="fas fa-sync-alt"></i></button>
            </form>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end col-4">
        <a href="{{route('create')}}" >
            <button class="btn btn-primary me-md-2">Add New Employee</button>
        </a>
        </div>
    </div>
    <table id="employee-table" class="display" style="width:100%">
        <thead>
        <tr>
            <th>Employee ID</th>
            <th>Employee Code</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Joining Date</th>
            <th>Profile Image</th>
            <th>Action</th>
            <!-- Add other table headers as needed -->
        </tr>
        </thead>
        <tbody>
        <!-- Table data will be populated here via AJAX -->
        </tbody>
    </table>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        $('#employee-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: '/get_employee', // Your Laravel route
                type: 'GET',
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'employee_code', name: 'employee_code'},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'joining_date', name: 'joining_date'},
                {data: 'profile_image', name: 'profile_image'},
                {data: 'action', name: 'action'},
                // Add other columns as needed
            ],
        });
    });
</script>

<script>
    $('#date_filter').submit(function (e) {
        e.preventDefault();

        var formData = $(this).serialize();
        $.ajax({
            // url: $(this).attr('action'),
            url: $(this).attr('action'),
            type: 'GET',
            data: formData,
            dataType: 'json',
            success: function (data) {
                var dataTable = $('#employee-table').DataTable();
                dataTable.clear();
                dataTable.rows.add(data.data);
                dataTable.draw();
            },
            error: function (xhr, status, error) {
            }
        });
    });
    $('#reset').click(function () {
        // Clear the date filter inputs
        $('#start_date').val('');
        $('#end_date').val('');

        // Trigger the form submission (reload all data)
        $('#date_filter').submit();
    });
</script>


</body>
</html>

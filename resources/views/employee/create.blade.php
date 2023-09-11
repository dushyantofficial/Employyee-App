<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        input[type=text], select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        input[type=date] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        label {
            padding: 12px 12px 12px 0;
            display: inline-block;
        }

        button[type=submit] {
            background-color: #04AA6D;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        button[type=submit]:hover {
            background-color: #45a049;
        }

        a {
            background-color: #045daa;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }
        a:hover{
            background-color: #45a049;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .col-25 {
            float: left;
            width: 25%;
            margin-top: 6px;
        }

        .col-75 {
            float: left;
            width: 75%;
            margin-top: 6px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 600px) {
            .col-25, .col-75, input[type=submit] {
                width: 100%;
                margin-top: 0;
            }
        }
    </style>
</head>
<body>

<h2>Create Employee</h2>

<div class="container">
    <form id="employeeForm" method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-25">
                <label for="first_name">First Name</label>
            </div>
            <div class="col-75">
                <input type="text" id="first_name" name="first_name" value="{{old('first_name')}}"
                       placeholder="Your name..">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="last_name">Last Name</label>
            </div>
            <div class="col-75">
                <input type="text" id="last_name" name="last_name" value="{{old('last_name')}}"
                       placeholder="Your last name..">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="joining_date">Joining Date</label>
            </div>
            <div class="col-75">
                <input type="date" id="joining_date" name="joining_date" value="{{date('d-m-y')}}"
                       placeholder="Your last name..">
            </div>
        </div>
        <div class="row">
            <div class="col-25">
                <label for="profile_image">Profile Image (Max 2MB)</label>
            </div>
            <div class="col-75">
                <input type="file" id="profile_image" name="profile_image" accept="image/*">
            </div>
        </div>

        <div class="row">
            <button type="submit">Add Employee</button>
            <a href="{{url('/')}}" class="btn btn-primary">Back</a> &nbsp;&nbsp;&nbsp;
        </div>
    </form>
</div>
<!-- Include jQuery from a CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Using a CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('form').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    // Handle success (e.g., show success message, clear the form)
                    // Example of a success alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Your employee create was successfully.',
                    });
                    $('form')[0].reset();
                },
                error: function (xhr) {
                    // Handle validation errors (e.g., display error messages)
                    var errors = xhr.responseJSON.errors;
                    var errorMessages = [];

                    for (var field in errors) {
                        errorMessages.push(errors[field][0]);
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: errorMessages.join('<br>') + '<br>', // Join error messages with <br> tags
                    });
                }
            });
        });
    });

</script>
</body>
</html>

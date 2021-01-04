<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <title>Laravel crud with ajax</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 mt-5">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategory">
                Add a category
            </button>

            <!-- Modal -->
            <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="message"></div>
                            <form id="category_form">
                                <div class="form-group">
                                    <label for="name">Category name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Category name">
                                </div>
                                <div class="form-group">
                                    <label for="description">Example textarea</label>
                                    <input class="form-control" id="description"  name="description" placeholder="Description" id="description">
                                </div>
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

{{-- ==================================================           Edit modal starts here ===============================--}}

            <div class="modal fade" id="edit_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" id="editCategoryModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="message"></div>
                            <form id="edit_category_form">
                                <div class="form-group">
                                    <label for="name">Category name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Category name">
                                </div>
                                <div class="form-group">
                                    <label for="description">Example textarea</label>
                                    <input class="form-control" id="description"  name="description" placeholder="Description" id="description">
                                </div>
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ==================================================           Edit modal ends here ===============================--}}
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Category list</h3>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody id="categoryTable">
                        @foreach($categories as $category)
                            <tr data-id="{{$category->id}}">

                                <td class="name">{{$category->name}}</td>
                                <td class="description">{{$category->description}}</td>
                                <td class="status">{{$category->status}}</td>
                                <td>
                                    <a class="btn btn-warning btn-sm edit_category" data-toggle="modal" data-target="#edit_category">Edit</a>
                                    <a class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

{{--Add category--}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#category_form').submit(function (e){
        e.preventDefault();
        let name= $('#category_form input[name ="name"]');
        let description = $('#category_form input[name ="description"]');
        let FormData = {
            name: $(name).val(),
            description: $(description).val(),
        }
        console.log(FormData);
        $.ajax({
            type:"POST",
            url:'category/store',
            data:FormData,
            success:function (data){
                let message = $('#message');

                $(message).append(
                    '<div class="alert alert-success">Category created</div>'
                );

                $(name).val('');
                $(description).val('');

                $('#categoryTable').prepend('<tr><td>'+data.name+'</td>' +
                    '<td>'+data.description+'</td>' +
                    '<td>'+data.status+'</td>' +
                    '<td>'+'<a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addCategory">Edit</a>\n' +
                    '       <a class="btn btn-danger btn-sm">Delete</a>'+'</td>' +
                    '</tr>');
            },

            error:function (error){
                $(message).html('');

                $.each(error.responseJSON.errors, function (index, value){
                        console.log(value[0]);
                });
            }
        });
    });


</script>

{{--Edit category--}}

<script>
    $(document).on('click', '.edit_category', function (){
        let category = $(this).closest('tr').data('id');
        let modal = $('#edit_category_form');
        $.ajax({
            type: 'GET',
            url:'category/edit/'+category,
            success: function (data){
                $(modal).find('#name').val(data.name);
                $(modal).find('#description').val(data.description);
                $(modal).attr('data-id',data.id);
            },

            error:function (error){
                console.log(error)
            },
        });
    });
</script>
{{--Update category--}}
<script>
    $('#edit_category_form').on('submit', function (e){
        e.preventDefault();
        let message = $('#message');


        let name= $('#edit_category_form input[name ="name"]');
        let description = $('#edit_category_form input[name ="description"]');
        let id = $('#edit_category_form').data('id');
        let FormData = {
            name: $(name).val(),
            description: $(description).val(),
        }
        $.ajax({
            type:"POST",
            url:'category/update/'+id,
            data:FormData,
            success:function (data){
                $(message).html('');

                $(message).append(
                    '<div class="alert alert-success">Category updated</div>'
                );

                $(name).val('');
                $(description).val('');

                let editRow = $('#categoryTable').find('tr[data-id="'+id+'"]');
                $(editRow).find('td.name').text(data.name);
                $(editRow).find('td.description').text(data.description);
                $(editRow).find('td.status').text(data.status);
            },

            error:function (error){
                $(message).html('');

                $.each(error.responseJSON.errors, function (index, value){
                    console.log(value[0]);
                });
            }
        });
    });
</script>

</body>
</html>

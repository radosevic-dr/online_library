<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .form-container {
            max-width: 500px;
            margin: 0 auto;
        }

        .form-container input,
        .form-container textarea,
        .form-container button {
            display: block;
            width: 100%;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <input type="text" name="name" placeholder="Category name">
            <textarea name="description" id="description" rows="4" cols="50"></textarea>
            <input type="file" name="icon" placeholder="Add img">
            <button>Add category</button>
        </form>
    </div>
</body>

</html>

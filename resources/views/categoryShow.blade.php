<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="alert alert-success">
        <strong>Category Created Successfully!</strong>
        <p>Name: {{ $category->name }}</p>
        <p>Description: {{ $category->description }}</p>
        @if ($category->icon)
            <img src="{{ asset('storage/' . $category->icon) }}" alt="Category Icon" width="100">
        @endif
    </div>
</body>
</html>

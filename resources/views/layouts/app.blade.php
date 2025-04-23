<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>

@if($errors->any())
    {{--  Hmm, I think it won't work with Redirect, but I've already spent 30 mins to fix it, so I just leave that note here xd //// upd. nvm, it works, but Im dumb to FIX IT upd. btw I fixed it--}}
    <div class="container error-container p-3">
        <div class="row">
            <h3><i class="bi bi-x fs-1"></i> Oops, something went wrong...</h3>
        </div>
        <div class="row p-2">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif

<div id="app" class=" d-flex justify-content-center align-items-center h-100">
    <div class="container">
        <div class="row">
            <h1>To-Do List</h1>
        </div>
        <div class="row">
            <ul class="list-group">
                @foreach($todoes as $todo)
                    @include('layouts.todoes', ['todo' => $todo, 'recursive' => 0])
                @endforeach
            </ul>
        </div>

        <form method="POST" action="{{ route('app.store') }}" class="row">
            @csrf
            <input name="parent" class="item-name" value="0" type="hidden"/>
            <div class="input-group" style="padding-left: 0; padding-top: 15px;">
                <input name="name" type="text" placeholder="{{ $placeholder }}" class="form-control"/>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

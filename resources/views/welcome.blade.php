<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT_Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="/images/favicon.png">

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{Route('index')}}">IT -Support</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @if (Route::has('login'))
                    @auth
                    <li class="nav-item">
                        <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                    </li>

                    @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Log in</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    </li>
                    @endif
                    @endauth
                    @endif
                </ul>

            </div>
        </div>
    </nav>
    <div>

    </div>

</body>

<div class="container">
    <div class="row">
        <form action="" method="post">
            <div class="col-md-5">
                <label for="emp_name" class="form-label">ชื่อ</label>
                <input type="text" name="emp_name" id="" class="form-control" placeholder="ระบุชื่อ">
            </div>
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <td scope="col"></td>
                            <td scope="col">#</td>
                            <td scope="col">รหัสทรัพสิน</td>
                            <td scope="col">ประเภท</td>
                            <td scope="col">หมายเหตุ</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="radio" name="radio" id="radio"></td>
                            <td> <label for="radio">fsdfds</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="" id=""></td>
                            <td></td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </form>
    </div>

</div>

</html>
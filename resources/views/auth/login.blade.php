<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 94%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #3490dc;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #2779bd;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .link {
            text-align: center;
            margin-top: 10px;
        }

        .link a {
            color: #3490dc;
            text-decoration: none;
        }
    </style>
</head>
<body>
@include('components.toast')

<div class="container">
    <h2>Login</h2>

    {{-- Error Message --}}
    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <div class="link">
        <p>Belum punya akun? <a href="/register">Register</a></p>
    </div>
</div>

</body>
</html>

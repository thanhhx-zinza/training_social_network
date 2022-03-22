<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3 w-25">
  <h2 class="text-center">Login Admin</h2>
  @if(session('message'))
        <div class="alert alert-danger" role="alert">
            {{session('message')}}
        </div>
  @endif
  <form action="{{ route("login.handleLogin") }}" method="post">
    <div class="mb-3 mt-3">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" value="{{ old("email") }}" placeholder="Enter email" name="email">
        @if(isset($errors) && $errors->has('email'))
            <div class="text text-danger">{{ $errors->first('email') }}</div>
        @endif
    </div>
    @csrf
    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
        @if(isset($errors) && $errors->has('password'))
            <div class="text text-danger">{{ $errors->first('password') }}</div>
        @endif
    </div>
    <div class="form-check mb-3">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="remember"> Remember me
      </label>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>

</body>
</html>

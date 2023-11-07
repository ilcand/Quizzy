<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/auth.css">
  <link rel="stylesheet" href="../css/mobileAuth.css">
  <title>Register</title>
</head>
<body>
  <nav id="navbar">
    <ul class="navbar-items">
      <li><a href="http://localhost/Quizzy/app/home">Home</a></li>
      <li><a href="http://localhost/Quizzy/app/">Login</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
  </nav>

  <section id="showcase">
    <div class="showcase-content">
      
      <div class="container">
        <h1>Register</h1>
        <form action="http://localhost/Quizzy/app/register" method="POST">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="password-confirm">Confirm Password</label>
            <input type="password" name="password-confirm" autocomplete="off" required>
          </div>

          <div class="form-group">
            <button type="submit" class="btn-submit">Register</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>
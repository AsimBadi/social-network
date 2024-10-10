<h2>Hey, {{ $user->username }}</h2>
<h4>Here's Your Email {{ $user->email }}</h4>
<p>To Change your Password Please Click on Given Link</p>
<a href="{{ url('forgot-password/'. $user->verifyUser->token) }}">Forgot Password</a>
Hi <strong>{{ $admin_full_name }}</strong>,

<p>You have created a user {{ $user_full_name }} as {{ $user_type }} in <a target="_blank" href="{{ $site_url }}">Symcom</a>.</p>

{{ $user_full_name }}'s login details are given below:<br>
Username: {{ $username }}<br>
Password: {{ $password }}<br>
Login Link: <a target="_blank" href="{{ $login_link }}">click here</a>

<p>If above login link don't work please try copy paste this below link in a new browser window<br>{{ $login_link }}</p>

<p><strong>Note: </strong> a mail is also send to {{ $user_full_name }} on Email : {{ $user_email }} provinding his/her login details.</p>

Thanks & Regards,<br>Team Symcom. 
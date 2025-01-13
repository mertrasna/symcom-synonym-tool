Hi <strong>{{ $user_full_name }}</strong>,

<p>You are receiving this mail because {{ $admin_full_name }} has careted your account in <a target="_blank" href="{{ $site_url }}">Symcom</a> as a {{ $user_type }} using your email. If it is not relevant to you please ignore this mail.</p>

Your login details are given below:<br>
Username: {{ $username }}<br>
Password: {{ $password }}<br>
Login Link: <a target="_blank" href="{{ $login_link }}">click here</a>

<p>If above login link don't work please try copy paste this below link in a new browser window<br>{{ $login_link }}</p>

Thanks & Regards,<br>Team Symcom. 
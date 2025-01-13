Hi <strong>{{ $receiver_name }}</strong>,
 
<p>You can reset your password by <a target="_blank" href="{{ $password_reset_link }}">clicking here</a></p>
<p>If above link don't work please try copy paste this below link in a new browser window<br>{{ $password_reset_link }}</p>

<p><strong style="color:#d93025;">*</strong> The link will expire after 60 minutes starting from : {{ $created_at }}</p>

Thanks & Regards,<br>Team Symcom. 
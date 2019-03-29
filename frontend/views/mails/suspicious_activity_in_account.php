Hello,<br/>
<br/>
We've noticed suspicious activity in your account. Maybe someone got your access data and logged into your account instead of you.<br/>
<br/>
Here are the details of the sign-in attempt:<br/>
<?=date('l jS \of F Y h:i:s A')?><br/>
Account: <?=$user->email?><br/>
IP Address: <?=$ip?><br/>
Operating system: <?=$os?><br/>
Browser: <?=$browser?><br/>
<br/>
To unlock your account - please follow the link:<br/>
<br/>
<a href="<?=$link?>"><?=$link?></a>
<br/>
After return we strongy recommend you to change your password and not telling it to anyone.<br/>
<br/>
Remember that your account is intended for use from one computer (or other device).<br/>
<br/>
<br/>
Yours securely,<br/>
Team MarketingHack.net<br/>
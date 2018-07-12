<form method="post">
	
<div class="row">
	<input type="text" name="file" />
</div>
<div class="row">
	<button type="submit" class="btn btn-primary">Gửi</button>
	
</div>

<input type="hidden" name="_token" value="{{csrf_token()}}">
</form>

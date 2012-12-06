<div class="captcha" id="captcha">
	<label for="captcha_input">CAPTCHA</label>
	<img src="{{ URL::to('user/captcha') }}?refresh={{ time() }}" alt="captcha" /> <a href="#">obnoviť kód</a><br />
	<input type="text" name="captcha" id="captcha_input" value="" />
</div>
<script type="text/javascript">
var foo={{ time() + 1 }};
$('#captcha a').click(function(){
	$('#captcha img').attr('src', '{{ URL::to('user/captcha') }}?refresh=' + foo);
	foo++;
});
</script>
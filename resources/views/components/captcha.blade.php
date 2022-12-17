<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Include script -->
<script type="text/javascript" defer>
    function callbackThen(response) {

        // read Promise object
        response.json().then(function(data) {
            console.log(data);
            if(data.success && data.score >= 0.6) {
                console.log('valid recaptcha');
            } else {
                document.getElementById('form').addEventListener('submit', function(event) {
                    event.preventDefault();
                    alert('recaptcha error');
                });
            }
        });
    }

    function callbackCatch(error){
        console.error('Error:', error)
    }
</script>

{!! htmlScriptTagJsApi([
   'callback_then' => 'callbackThen',
   'callback_catch' => 'callbackCatch',
]) !!}

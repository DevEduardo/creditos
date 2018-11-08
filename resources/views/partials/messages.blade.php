@push('js')
	
	@if (alert()->ready())
	    <script>
	        swal({
	            title: "{!! alert()->message() !!}",
	            text: "{!! alert()->option('text') !!}",
          		type: "{!! alert()->type() !!}"
	        });
	    </script>
	@endif

@endpush
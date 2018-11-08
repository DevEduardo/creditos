<div class="form-group">
    {{-- Form::label($name, null, ['class' => 'control-label'])--}}
    {{ Form::text($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}

	
	<!--  Esto en el Form -->

    {{-- Form::component('bsText', 'components.form.text', ['name', 'value' => null, 'attributes' => []]) --}}
</div>
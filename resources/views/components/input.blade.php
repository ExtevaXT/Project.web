<div class="mb-3">
    <input name="{{$name}}"
           class="@error($name) is-invalid @enderror p-2 input-glass d-inline-block w-100"
           type="{{$type}}"
           placeholder="{{$placeholder}}"
           autocomplete="off">
    @error($name)
    <div id="invalid{{$name}}" class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</div>

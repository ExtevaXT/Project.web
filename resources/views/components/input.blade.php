<div class="mb-3">
    <input name="{{$name}}"
           class="@error($name) is-invalid @enderror p-2 bg-glass form-control d-inline-block"
           type="{{$type}}"
           placeholder="{{$placeholder}}"
           autocomplete="off">
    @error($name)
    <div id="invalid{{$name}}" class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</div>

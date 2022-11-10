<div class="mb-2">
    <input name="{{$name}}"
           class="@error($name) is-invalid @enderror p-2 border border-primary form-control d-inline-block"
           type="{{$type}}"
           placeholder="{{$placeholder}}"
           autocomplete="off">
    @error($name)
    <div id="invalid{{$name}}" class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</div>

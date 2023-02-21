<div class="mb-3 {{isset($bool) ? $bool ? 'bg-glass-success' : 'bg-glass-danger' : null}}">
    <input name="name"
           class="@error('name') is-invalid @enderror p-2 input-glass d-inline-block w-75 border-end-0"
           type="text"
           placeholder="Login"
           autocomplete="off"
           wire:model.lazy="login"
    >
    <button type="button" class="float-end input-glass p-2 w-25 text-center" wire:click="check">Check</button>
    @error('name')<div id="invalidName" class="invalid-feedback">{{$message}}</div>@enderror
</div>

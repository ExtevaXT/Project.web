<div class="mb-3">
    <input name="name"
           class="@error('name') is-invalid @enderror p-2 input-glass d-inline-block w-75 border-end-0"
           type="text"
           placeholder="Login"
           autocomplete="off"
           wire:model="login"
    >
    <span class="float-end bg-glass p-2 w-25 text-center" wire:click="check">Check</span>
    @error('name')<div id="invalidName" class="invalid-feedback">{{$message}}</div>@enderror
    {{var_dump($login)}}
</div>

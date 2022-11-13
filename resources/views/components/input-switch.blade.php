<div class="border-primary border p-2 my-2">
    <div class="form-check form-switch fs-3">
        <label class="form-check-label fs-5" for="{{$name}}">{{$label}}
            <div class="text-secondary fs-6">Description</div>
        </label>
        <input type='hidden' value='0' name='{{$name}}'>
        <input name="{{$name}}" value='1' class="form-check-input mt-3" type="checkbox" role="switch" id="{{$name}}"
               @if($checked) checked @endif>
    </div>
</div>

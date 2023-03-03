<div class="mt-2">
    <form action="/guides/search" class="mt-3 d-inline-flex w-100" autocomplete="off">
        <input class="my-1 p-2 input-glass w-100"
               placeholder="Search (/n {input} - names only, /c {input} - categories only)"
               onkeydown = "if (event.keyCode == 13)
                    this.form.submit()"

               id="input" name="input">
        <button class="input-glass w-25 my-1" type="submit">Search</button>
    </form>
</div>

<?php
$trashed = 'hide';
if ($trashable
    && !empty($validated)
    && !empty($validated['filter'])
    && !empty($validated['filter']['trash'])
) {
    if ('with' === $validated['filter']['trash']) {
        $trashed = 'with';
    } elseif ('only' === $validated['filter']['trash']) {
        $trashed = 'only';
    }
}
?>
<fieldset class="mb-3" id="{{$id}}-fieldset-filter-ids">
    <legend>
        Filter Trash
    </legend>

    <div class="container collapse show">
        <div class="row">

            <div class="col">
                <div class="input-group mb-3">

                    <div class="form-check me-2">
                        <input class="form-check-input" type="radio" name="filter[trash]" id="filter_trash" {{'hide' === $trashed ? 'checked' : ''}} value="">
                        <label class="form-check-label" for="filter_trash">
                            <i class="fa-regular fa-trash-can"></i>
                            Hide Trash
                        </label>
                    </div>
                    <div class="form-check me-2">
                        <input class="form-check-input" type="radio" name="filter[trash]" id="filter_trash_with" {{'with' === $trashed ? 'checked' : ''}} value="with">
                        <label class="form-check-label" for="filter_trash_with">
                            <i class="fa-solid fa-trash"></i>
                            With Trash
                        </label>
                    </div>
                    <div class="form-check me-2">
                        <input class="form-check-input" type="radio" name="filter[trash]" id="filter_trash_only" {{'only' === $trashed ? 'checked' : ''}} value="only">
                        <label class="form-check-label" for="filter_trash_only">
                            <i class="fa-solid fa-trash-arrow-up"></i>
                            Only Trash
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>

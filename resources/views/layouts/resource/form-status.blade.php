<fieldset class="mb-3">

    <legend>Status</legend>

    <fieldset>

        <div class="row">
            <div class="col">
                <div class="form-check form-check-inline">
                    <input type="hidden" name="active" value="0" >
                    <input class="form-check-input" type="checkbox" id="status_active" name="active" value="1" {{old('active') ? 'checked' : ''}}>
                    <label class="form-check-label" for="status_active">Active</label>
                </div>
            </div>
            <div class="col">
                <div class="form-check form-check-inline">
                    <input type="hidden" name="locked" value="0" >
                    <input class="form-check-input" type="checkbox" id="status_locked" name="locked" value="1" {{old('locked') ? 'checked' : ''}}>
                    <label class="form-check-label" for="status_locked">Locked</label>
                </div>
            </div>
            <div class="col">
                <div class="form-check form-check-inline">
                    <input type="hidden" name="flagged" value="0" >
                    <input class="form-check-input" type="checkbox" id="status_flagged" name="flagged" value="1" {{old('flagged') ? 'checked' : ''}}>
                    <label class="form-check-label" for="status_flagged">Flagged</label>
                </div>
            </div>
        </div>

    </fieldset>

    @yield('fieldset-status')

</fieldset>

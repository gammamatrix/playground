<fieldset class="mb-3">

    <legend>{{ __('playground::pagination.form.label') }}</legend>

    <div class="input-group mb-3">

        <label class="input-group-text" for="form_per_page">
            {{ __('playground::pagination.show', [
                'currentPage' => $paginator->currentPage(),
                'lastPage' => $paginator->lastPage(),
                'perPage' => $paginator->perPage(),
            ]) }}
        </label>

        <select class="form-select" id="form_per_page" name="perPage">
            @foreach ($page_options as $key => $value)
                <option value="{{ $value }}" {{ $value === $perPage ? 'selected' : '' }}>{{ $value }}
                </option>
            @endforeach
        </select>

        @if (!empty($validated['page']))
            <input type="hidden" name="page" value="{{ $validated['page'] }}" />
        @endif

        <span class="input-group-text">
            {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }}
        </span>

        <button type="submit" class="btn btn-success">
            {{ __('playground::pagination.go') }}
        </button>
    </div>

</fieldset>

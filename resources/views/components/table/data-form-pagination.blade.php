<fieldset class="mb-3">

    <legend>Pagination Options</legend>

    <div class="input-group mb-3">

        <label class="input-group-text" for="form_per_page">
            Showing page {{$paginator->currentPage()}} of {{$paginator->lastPage()}} with {{$paginator->perPage()}} per page:
        </label>

        <select class="form-select" id="form_per_page" name="perPage">
            @foreach ($page_options as $key => $value)
                <option value="{{$value}}" {{$value === $perPage ? 'selected' : ''}}>{{$value}}</option>
            @endforeach
        </select>

        @if (!empty($validated['page']))
        <input type="hidden" name="page" value="{{$validated['page']}}" />
        @endif

        <span class="input-group-text">
            {{$paginator->firstItem()}} - {{$paginator->lastItem()}}
        </span>

        <button type="submit" class="btn btn-success">
            Go
        </button>
    </div>

</fieldset>

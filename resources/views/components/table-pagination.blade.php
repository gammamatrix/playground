<div>
<?php
$params = \Request::all();
if (array_key_exists('perPage', $params)) {
    unset($params['perPage']);
}
// dump([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$params' => $params,
// ]);
?>
    {{-- <form method="get" action="{{sprintf('%s?%s', \Request::url(), http_build_query($params))}}"> --}}
        <div class="input-group mb-3">

            <label class="input-group-text" for="form_per_page">
                Showing page {{$paginator->currentPage()}} of {{$paginator->lastPage()}} with {{$paginator->perPage()}} per page:
            </label>
<?php
// dd([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$validated' => $validated,
// ]);
$perPage = $paginator->perPage();
$options = [
    1,
    2,
    3,
    4,
    5,
    6,
    7,
    8,
    9,
    10,
    15,
    20,
    25,
    30,
    35,
    50,
    100,
];

?>
            <select class="form-select" id="form_per_page" name="perPage">
                @foreach ($options as $key => $value)
                    <option value="{{$value}}" {{$value === $perPage ? 'selected' : ''}}>{{$value}}</option>
                @endforeach
            </select>

            <span class="input-group-text">
                {{$paginator->firstItem()}} - {{$paginator->lastItem()}}
            </span>

            <button type="submit" class="btn btn-primary">
                Go
            </button>
        </div>
    {{-- </form> --}}


</div>

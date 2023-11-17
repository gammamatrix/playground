<?php
/**
 * API Layout: form
 *
 *
 * resources/views/layouts/api/form.blade.php
 *
 */

$package_config = config('playground');

/**
 * @var boolean|string $withFormInfo
 */
$withFormInfo = isset($withFormInfo) && (is_bool($withFormInfo) || is_string($withFormInfo)) ? $withFormInfo : true;

/**
 * @var boolean $withFormLabel
 */
$withFormLabel = isset($withFormLabel) && is_bool($withFormLabel) ? $withFormLabel : true;

/**
 * @var boolean $withFormSlug
 */
$withFormSlug = isset($withFormSlug) && is_bool($withFormSlug) ? $withFormSlug : true;

/**
 * @var boolean $withFormParent
 */
$withFormParent = isset($withFormParent) && is_bool($withFormParent) ? $withFormParent : true;

/**
 * @var boolean $withFormSpec
 */
$withFormSpec = isset($withFormSpec) && is_bool($withFormSpec) ? $withFormSpec : true;

/**
 * @var boolean|string $withFormButtons
 */
$withFormButtons = isset($withFormButtons) && (is_bool($withFormButtons) || is_string($withFormButtons)) ? $withFormButtons : true;

/**
 * @var boolean|string $withFormStatus
 */
$withFormStatus = isset($withFormStatus) && (is_bool($withFormStatus) || is_string($withFormStatus)) ? $withFormStatus : true;

/**
 * @var boolean $withFormContent
 */
$withFormContent = isset($withFormContent) && is_bool($withFormContent) ? $withFormContent : true;

/**
 * @var boolean $withFormDescription
 */
$withFormDescription = isset($withFormDescription) && is_bool($withFormDescription) ? $withFormDescription : true;

/**
 * @var boolean $withFormIntroduction
 */
$withFormIntroduction = isset($withFormIntroduction) && is_bool($withFormIntroduction) ? $withFormIntroduction : true;

/**
 * @var boolean $withFormSummary
 */
$withFormSummary = isset($withFormSummary) && is_bool($withFormSummary) ? $withFormSummary : true;

$formTitle = '';
$_methodUrl = '';
$_method = empty($_method) ? '' : $_method;
if ('patch' === $_method) {
    $formTitle = sprintf('Editing: %1$s', $data[ $meta['info']['model_attribute'] ]);
    $_methodUrl = route(sprintf('%1$s.patch', $meta['info']['model_route']), $data->id);
} elseif ('post' === $_method) {
    $formTitle = sprintf('Create a %1$s', $meta['info']['model_label']);
    $_methodUrl = route(sprintf('%1$s.post', $meta['info']['model_route']));
}

?>
@extends($package_config['layout'], [
    'withEditor' => true,
])
@section('title', sprintf('%1$s - %2$s Form', $meta['info']['module_label'], $meta['info']['model_label']))
@section('breadcrumbs')
<nav aria-label="breadcrumb" class="container-fluid mt-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route($meta['info']['module_route']) }}">{{$meta['info']['module_label']}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route($meta['info']['model_route']) }}">{{$meta['info']['model_label']}} Index</a></li>
        @if ('post' === $_method)
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route(sprintf('%1$s.create', $meta['info']['model_route'])) }}">Create</a></li>
        @elseif ('patch' === $_method)
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route(sprintf('%1$s.edit', $meta['info']['model_route']), [$meta['info']['model_slug'] => $data->id ]) }}">{{$formTitle}}</a></li>
        @endif
    </ol>
</nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-md-12">

            <form method="POST" action="{{$_methodUrl}}" class="needs-validation" novalidate>

@method($_method)

@csrf

<input type="hidden" name="_return_url" value="{{ old('_return_url') }}">

@if ('patch' === $_method)

<input type="hidden" name="id" value="{{ old('id') }}">

@endif

@yield('form-primary')

@if ($withFormInfo)
@if (is_string($withFormInfo))
    @include($withFormInfo)
@else
    @include('playground::layouts.resource.form-information')
@endif
@endif

@yield('form-secondary')

@if ($withFormStatus)
@if (is_string($withFormStatus))
    @include($withFormStatus)
@else
    @include('playground::layouts.resource.form-status')
@endif
@endif

@yield('form-tertiary')

@if ($withFormContent || $withFormDescription || $withFormContent || $withFormContent)
@include('playground::layouts.resource.form-content')
@endif

@yield('form-quaternary')

@if ($withFormButtons)
    @if (is_string($withFormButtons))
@include($withFormButtons)
    @else
                <fieldset class="mb-3">
                    <div class="button-group float-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <a class="btn btn-danger" href="{{ route($meta['info']['model_route']) }}">Cancel</a>
                    </div>
                </fieldset>
    @endif
@endif

@yield('form-quinary')

            </form>

        </div>

    </div>
</div>
@endsection

@push('body')
<script type="application/javascript">
window.onload = function() {
    'use strict';
@if ($withFormSummary)
    if (typeof playground === 'object') {
        playground.forms.editor('#form-input-summary');
    }
@endif
@if ($withFormContent)
    if (typeof playground === 'object') {
        playground.forms.editor('#form-input-content');
    }
@endif
    if (typeof playground === 'object') {
        playground.forms.validation();
    }
}
</script>
@endpush

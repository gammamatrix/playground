<fieldset class="mb-3">

    <legend>Information</legend>

@if ($withFormLabel)
@formInput([
    'label' => 'Label',
    'column' => 'label',
    'autocomplete'=> false,
    'rules'=> [
        'required' => true,
        'maxlength' => 255,
    ],
])
@endif

@if ($withFormSlug)
@formInput([
    'label' => 'SLUG',
    'column' => 'slug',
    'autocomplete'=> false,
    'rules'=> [
        'required' => 'patch' === $_method,
        'maxlength' => 255,
    ],
])
@endif

@if ($withFormParent)
@formSelect([
    'label' => sprintf('%1$s Parent', $meta['info']['module_label']),
    'column' => 'parent_id',
    'default' => true,
    'key' => $meta['info']['model_attribute'],
    'records'=> $parents,
])
@endif

@yield('fieldset-information')

</fieldset>

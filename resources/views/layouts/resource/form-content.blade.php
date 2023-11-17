<fieldset class="mb-3">

    <legend>Content Details</legend>

@if ($withFormIntroduction)
<x-playground::forms.column column="introduction" label="Introduction" :rules="['maxlength' => 255,]" :autocomplete="false" />
@endif

@if ($withFormContent)
<x-playground::forms.column-editor column="content" label="Content" />
@endif

@if ($withFormSummary)
<x-playground::forms.column-editor column="summary" label="Summary" />
@endif

@if ($withFormDescription)
<x-playground::forms.column column="description" label="Description" :rules="['maxlength' => 255,]" :autocomplete="false" />
@endif

@yield('fieldset-content')

</fieldset>

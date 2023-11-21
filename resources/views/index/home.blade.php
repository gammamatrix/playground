@extends($package_config['layout'])
@section('title', __('Home'))
@section('breadcrumbs')
<nav aria-label="breadcrumb" class="m-3">
    <ol class="breadcrumb">
        @if (Route::has('home'))
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
        @endif
    </ol>
</nav>
@endsection

@section('content')

{{-- <div id="vue_app">
    <example-component></example-component>
</div> --}}

{{-- <div id="testing">
    <testing />
</div> --}}

{{-- <div id="app">@{{ message }}</div> --}}

@endsection

@push('body')

<script type="application/javascript">
console.log('home.blade', {
    window: window,
});

// window.onload = function() {
//     'use strict';
//     console.debug('{{__FILE__}}')
//     // if (document.querySelector('#vue_app')) {
//     //     window.app.mount('#vue_app');
//     // }
//
//     if (document.querySelector('#testing')) {
//
//         app.component('testing', {
//             data() {
//                 return {
//                     message: 'Hello testing!!!'
//                 }
//             },
//             render() {
//                 return this.message
//             }
//         });
//
//         window.app.mount('#testing');
//     }
//
// }
</script>

<script>
// const {createApp} = Vue
//
// const app = createApp({})
// app.component('example-component', {
//     data() {
//         return {
//             message: 'Hello Vue!!!'
//         }
//     },
//     render() {
//         return this.message
//     }
// });
//
// app.mount('#app')

// const { createApp } = Vue
//
// createApp({
//   data() {
//     return {
//       message: 'Hello Vue!'
//     }
//   }
// }).mount('#app')
</script>
@endpush

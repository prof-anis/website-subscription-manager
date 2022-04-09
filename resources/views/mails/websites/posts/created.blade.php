@component('mail::message')
# Their is a new post from {{ $website->name }} titled {{ $post->title }}. Here is a sneak peek

<br>

{{ $post->description }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

This is an example of post

<h1>
    {{ $entry->title }}
</h1>

<p>
    Created by: {{ $entry->author->name }}
</p>

<p>
    Created at: {{ $entry->getEntryModel()->created_at }}
</p>

{{ $entry->body }}

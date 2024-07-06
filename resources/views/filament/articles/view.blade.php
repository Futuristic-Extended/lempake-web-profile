<x-filament-panels::page>
  <img src="{{ \Storage::disk('thumbnails')->url($record->thumbnail_lg_filename) }}" class="border-red" alt="Thumbnail">
  {!! $record->content !!}
</x-filament-panels::page>
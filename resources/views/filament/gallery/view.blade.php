@vite('resources/css/app.css')

<x-filament-panels::page>
  <div class="grid grid-cols-4 gap-3">
    @foreach ($record->images as $image)
      <img src="{{ Storage::disk('galleries')->url($image->image_sm_filename) }}" />
    @endforeach
  </div>
</x-filament-panels::page>
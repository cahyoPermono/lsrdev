<div>
    <button wire:click="selectAllModules">Select All</button>
    <button wire:click="unselectAllModules">Unselect All</button>
</div>
<div>
    @foreach ($app_modules as $data)
        <div>
            <input type="checkbox" wire:model="selectedModules.{{ $data->id }}" value="{{ $data->id }}">
            {{ $data->name }}
        </div>
    @endforeach
</div>
<x-portal::input type="text" name="value" label="Max in Active Day" placeholder="Max in Active Day" horizontal>
    {{ $model::where('key', 'Max in Active Day')->first()->value ?? old('value') }}
</x-portal::input>

<x-portal::input type="text" name="name" label="Name" placeholder="Name" horizontal>{{old('name')}}</x-portal::input>
<x-portal::input type="file" name="icon" label="Icon" placeholder="Icon" horizontal>{{old('icon')}}</x-portal::input>
<x-portal::input type="text" name="key" id="key" label="Key" placeholder="Key" horizontal>{{old('key')}}</x-portal::input>
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var nameInput = document.getElementById('name');
        var keyInput = document.getElementById('key');

        nameInput.addEventListener('input', function () {
            var nameValue = this.value;
            var key = generateKeyFromName(nameValue);
            keyInput.value = key;
        });

        function generateKeyFromName(name) {
            var key = name.replace(/[^a-za-z0-9]/g, '-');
            return key;
        }

        var pathInput = document.getElementById('path');
        pathInput.addEventListener('input', function () {
            var pathValue = this.value;
            var key = generateKeyFromPath(pathValue);
            keyInput.value = key;
        });

        function generateKeyFromPath(path) {
            var key = path.replace(/[^a-za-z0-9]/g, '-');
            return key;
        }
    });
</script>
@endpush
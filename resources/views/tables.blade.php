<!DOCTYPE html>
<html>
<head>
    <title>Select or Enter Table</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form id="exportForm">
        @csrf
        <label for="table">Select Table:</label>
        <select name="table" id="table">
            @foreach ($tables as $table)
                <option value="{{ $table }}">{{ $table }}</option>
            @endforeach
        </select>
        <br>
        <br>
        <button type="button" onclick="showJson()">Convert and Show JSON</button>
        <button type="button" onclick="insertJson()">Convert and Insert JSON</button>
    </form>
    <div id="jsonResult" style="margin-top: 20px; display: none;">
        <h3>JSON Result:</h3>
        <pre id="jsonData"></pre>
    </div>
    <script>
        function showJson() {
            $.ajax({
                url: '/show-json',
                type: 'POST',
                data: $('#exportForm').serialize(),
                success: function(response) {
                    $('#jsonData').text(JSON.stringify(response, null, 2));
                    $('#jsonResult').show();
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }

        function insertJson() {
            $.ajax({
                url: '/insert-json',
                type: 'POST',
                data: $('#exportForm').serialize(),
                success: function(response) {
                    alert('Data successfully inserted into MongoDB!');
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }
    </script>
</body>
</html>

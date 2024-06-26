<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KanyeRest</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center my-4">
            <h1>Random Kanye West Quotes</h1>
            <div class="d-flex justify-content-between gap-1">
                <button id="copyButton" class="btn btn-success mx-2" onclick="copyToClipboard()">Copy API Access Token</button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger" type="submit">Logout</button>
                </form>
            </div>
        </div>
        <ul id="quotes-list" class="list-group mb-4">
            @foreach ($randomQuotes as $quote)
                <li class="list-group-item">{{ $quote }}</li>
            @endforeach
        </ul>
        <button id="refresh-quotes" class="btn btn-primary">Refresh Quotes</button>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#refresh-quotes').click(function() {
                $.ajax({
                    url: '/quotes/refresh',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        var quotesList = $('#quotes-list');
                        quotesList.empty();
                        data.forEach(function(quote) {
                            quotesList.append('<li class="list-group-item">' + quote + '</li>');
                        });
                    }
                });
            });
        });
    </script>

    <script>
        function copyToClipboard() {
            var token = "{{ $token }}";
            var tempInput = document.createElement("input");
            tempInput.value = token;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

            // Change button text
            var copyButton = document.getElementById("copyButton");
            var originalText = copyButton.textContent;
            copyButton.textContent = "Copied Access Token!";

            // Revert button text after 3 seconds
            setTimeout(function() {
                copyButton.textContent = originalText;
            }, 3000);
        }
    </script>
</body>
</html>

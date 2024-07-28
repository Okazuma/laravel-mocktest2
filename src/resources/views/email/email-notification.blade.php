<!DOCTYPE html>
<html>
<head>
    <style>
        /* インラインスタイルやスタイルタグを使ってCSSを定義 */
        .email-body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-header {
            font-size: 24px;
            color: #333;
        }
        .email-content {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="email-body">
        <div class="email-header">
            {{ $subject }}
        </div>
        <div class="email-content">
            {!! $content !!}
        </div>
    </div>
</body>
</html>

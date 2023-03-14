<!DOCTYPE html>
<html>
<head>
    <title>Data Page</title>
</head>
<body>
    <h1>Data</h1>
    <table>
        <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($freeGifts['freeGifts'] as $freeGift)
    <tr>
        <td>{{ $freeGift['id'] }}</td>
        <td>{{ $freeGift['giftName'] }}</td>
        <td>{{ $freeGift['giftDesc'] }}</td>
        <td>{{ $freeGift['giftRequiredPrice'] }}</td>
        <td>{{ $freeGift['image'] }}</td>
    </tr>
@endforeach




        </tbody>
    </table>
</body>
<script>
    
    </script>
</html>

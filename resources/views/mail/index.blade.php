<!DOCTYPE html>
<html>

<body style="color: black;">

    <h1>{{ $details['title'] }}</h1>
    <p>{{ $details['body'] }}</p>

    @isset($details['dospem'])
        <ul>
            <li>{{ $details['dospem'] }}</li>
            <li>{{ $details['mhs'] }}</li>
        </ul>
    @endisset

    <p>Dimohon untuk segara menindaklanjuti informasi terkait.</p>
</body>

</html>

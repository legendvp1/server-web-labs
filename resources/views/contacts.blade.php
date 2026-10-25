@extends('layout')

@section('title', 'Контакты')

@section('content')
    <h1>Контакты</h1>

    <table>
        @foreach ($contacts as $contact)
            <tr>
                <td>{{ $contact['name'] }}</td>
                <td>{{ $contact['value'] }}</td>
            </tr>
        @endforeach
    </table>
@endsection

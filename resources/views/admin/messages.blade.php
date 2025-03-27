<!-- resources/views/admin/messages.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Messages in Process</h1>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Message</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($messages as $message)
            <tr>
                <td>{{ $message->id }}</td>
                <td>{{ $message->user_id }}</td>
                <td>{{ $message->content }}</td>
                <td>{{ $message->status }}</td>
                <td>
                    <form action="/admin/messages/{{ $message->id }}/complete" method="POST">
                        @csrf
                        <button type="submit">Complete Processing</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

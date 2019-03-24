@extends('layouts.app')

@section('header')
    <h1>
        Items
        <a href="{{ route('items.create') }}">
            <button type="button" class="btn btn-primary">Create</button>
        </a>
    </h1>
@endsection

@section('content')
    <div class="col-md-12">
        @if($items->count())
            <table class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITLE</th>
                    <th>BODY</th>
                        <th class="text-right">OPTIONS</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->title}}</td>
                <td>{{$item->body}}</td>
                            <td class="text-right">
                                <a class="btn btn-xs btn-primary" href="{{ route('items.show', $item->id) }}"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                                <a class="btn btn-xs btn-warning" href="{{ route('items.edit', $item->id) }}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $items->render() !!}
        @else
            <h3 class="text-center alert alert-info">Empty!</h3>
        @endif

    </div>

@endsection
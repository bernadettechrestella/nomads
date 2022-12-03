@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
    </div>

    <div class="row">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Travel</td>
                            <td>User</td>
                            <td>Visa</td>
                            <td>Total</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->travel_packages->title }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->additional_visa }}</td>
                            <td>{{ $item->transactions_total }}</td>
                            <td>{{ $item->transactions_status }}</td>
                            <td>
                                <a href="{{ route('transactions.show', $item->id) }}" class="btn">
                                    <i class="fa fa-eye" style="color:green;"></i>
                                </a>
                                <a href="{{ route('transactions.edit', $item->id) }}" class="btn">
                                    <i class="fa fa-pencil-alt" style="color:blue;"></i>
                                </a>
                                <form action="{{ route('transactions.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn">
                                        <i class="fa fa-trash" style="color:red;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Data Kosong
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
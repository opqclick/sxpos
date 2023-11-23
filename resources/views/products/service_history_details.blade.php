@extends('layouts.app')

@section('page-title', __('Service History'))

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Service History') }}</h5>
    </div>
@endsection

@section('action-btn')


@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Service History') }}</li>
@endsection

@section('content')
    @can('Manage Product')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header card-body table-border-style">
                         <h5></h5>
                        <div class="table-responsive">
                            <table class="table" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="w-25">{{ __('Date') }}</th>
                                        <th>{{ __('Ref Number') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Product Name') }}</th>
                                        <th>{{ __('Category Name') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sellItems as $key => $sellItem)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ Auth::user()->datetimeFormat($sellItem->created_at) }}/td>
                                            <td>{{ $sellItem->ref_id }}</td>
                                            <td>{{ $sellItem->price * $sellItem->quantity }}</td>
                                            <td>
                                                {{ $sellItem->product->name }}
                                            </td>
                                            <td>{{ $category->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('scripts')

    <script>

        $(document).on("click","th[data-sortable]",function() {
            $(".product_barcode").each(function() {
                var id = $(this).attr("id");
                var sku = $(this).data('skucode');
                generateBarcode(sku, id);
            });
        });

        function is_Dash(str) {
            regexp = /[\-]+/i;

            if (regexp.test(str)) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endpush


<div class="row mt-4">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5><span class="shd-type">{{ strtoupper($type) }}</span> <span class="shd-category-name">{{ $category->name }}</span> History for <span class="shd-customer-name">{{ $customer->name }}</span></h5>
            </div>
            <div class="card-body table-border-style">
                @if(count($sellItems) > 0)
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
                                    <td>{{ Auth::user()->datetimeFormat($sellItem->created_at) }}</td>
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
                @else
                    <h4 class="text-center text-danger">{{ __('No Data Found') }}</h4>
                @endif

            </div>
        </div>
    </div>
</div>

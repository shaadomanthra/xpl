
 @if($products->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$products->total()}})</th>
                <th scope="col">Products </th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Validity</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $key=>$product)  
              <tr>
                <th scope="row">{{ $products->currentpage() ? ($products->currentpage()-1) * $products->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('productpage',$product->slug) }} ">
                  {{ $product->name }}
                  </a>
                </td>
                <td>
                  {!! $product->description !!}
                </td>

                <td>
                  @if($product->price !=0)
                  <i class="fa fa-rupee"></i>{{ $product->price }}
                  @else
                    <span class="badge badge-warning">FREE</span>
                  @endif
                </td>

                <td>{{ $product->validity}} months</td>
                
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Products listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($products->total() > config('global.no_of_records'))mt-3 @endif">
        {{$products->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>

<nav aria-label="Page navigation" class="mt-5" ng-show="pagination{{ $suffix }} > 1">
  <ul class="pagination justify-content-center mb-0" ng-init="current_page{{ $suffix }}=1">
    <li class="page-item" ng-class="{'active':$index+1==current_page{{ $suffix }}}" ng-repeat="p in [] | range:pagination{{ $suffix }}" ng-show="$index+1==1 || $index+1==current_page{{ $suffix }}-2 || $index+1==current_page{{ $suffix }}-1 || $index+1==current_page{{ $suffix }} || $index+1==current_page{{ $suffix }}+1 || $index+1==pagination{{ $suffix }} || (current_page{{ $suffix }}<3 && $index+1<5) || (current_page{{ $suffix }}>pagination{{ $suffix }}-2 && $index+1>pagination{{ $suffix }}-4)">
      <button type="button" class="page-link" ng-click="paginate{{ $suffix }}($index+1)">@{{$index+1}}</button>
    </li>
  </ul>
  <div class="text-center mt-2">
    <span class="text-muted" aria-hidden="true"><small>{!! __('general.pagination_info', ['suffix' => $suffix]) !!}</small></span>
  </div>
</nav>
<?php use Illuminate\Pagination\Paginator; ?>
<nav class="custome-pagination">
	<ul class="pagination justify-content-center">
		@if ($paginator->lastPage() > 1)
			@if (!$paginator->onFirstPage())
				<li class="page-item">
					<a class="page-link" href="{{ PaginateRoute::previousPageUrl($paginator) }}" tabindex="-1" aria-disabled="true">
						<i class="fa-solid fa-angles-left"></i>
					</a>
				</li>
			@endif
			@for ($i = 1; $i <= $paginator->lastPage(); $i++)
				<?php
				$half_total_links = floor(6 / 2);
				$from = $paginator->currentPage() - $half_total_links;
				$to = $paginator->currentPage() + $half_total_links;
				if ($paginator->currentPage() < $half_total_links) {
					$to += $half_total_links - $paginator->currentPage();
				}
				if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
					$from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
				}
				?>
				@if ($from < $i && $i < $to)
					@if($paginator->currentPage() == $i)
						<li class="page-item active">
							<a class="page-link" href="javascript:void(0)">{{$i}}</a>
						</li>
					@else
						<li class="page-item" aria-current="page">
							<a class="page-link" href="{{  PaginateRoute::pageUrl($i) }}">{{$i}}</a>
						</li>
					@endif
				@endif
			@endfor
			@if($paginator->hasMorePages())
				<li class="page-item">
					<a class="page-link" href="{{  PaginateRoute::nextPageUrl($paginator) }}">
						<i class="fa-solid fa-angles-right"></i>
					</a>
				</li>
			@endif
		@endif
	</ul>
</nav>
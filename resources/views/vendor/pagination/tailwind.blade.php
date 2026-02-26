@if ($paginator->hasPages())
   <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination-nav">

      <div class="pagination-mobile sm:hidden">
         @if ($paginator->onFirstPage())
            <span class="pg-link pg-disabled">
               {!! __('pagination.previous') !!}
            </span>
         @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pg-link">
               {!! __('pagination.previous') !!}
            </a>
         @endif

         @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pg-link">
               {!! __('pagination.next') !!}
            </a>
         @else
            <span class="pg-link pg-disabled">
               {!! __('pagination.next') !!}
            </span>
         @endif
      </div>

      <div class="pagination-desktop hidden sm:flex">
         <p class="pg-info">
            {!! __('Showing') !!}
            @if ($paginator->firstItem())
               <span class="pg-info-num">{{ $paginator->firstItem() }}</span>
               {!! __('to') !!}
               <span class="pg-info-num">{{ $paginator->lastItem() }}</span>
            @else
               {{ $paginator->count() }}
            @endif
            {!! __('of') !!}
            <span class="pg-info-num">{{ $paginator->total() }}</span>
            {!! __('results') !!}
         </p>

         <div class="pg-links">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
               <span class="pg-link pg-arrow pg-disabled pg-first" aria-disabled="true">
                  <svg class="pg-icon" fill="currentColor" viewBox="0 0 20 20">
                     <path fill-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                  </svg>
               </span>
            @else
               <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pg-link pg-arrow pg-first"
                  aria-label="{{ __('pagination.previous') }}">
                  <svg class="pg-icon" fill="currentColor" viewBox="0 0 20 20">
                     <path fill-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                  </svg>
               </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
               @if (is_string($element))
                  <span class="pg-link pg-dots">{{ $element }}</span>
               @endif

               @if (is_array($element))
                  @foreach ($element as $page => $url)
                     @if ($page == $paginator->currentPage())
                        <span class="pg-link pg-current" aria-current="page">{{ $page }}</span>
                     @else
                        <a href="{{ $url }}" class="pg-link"
                           aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                           {{ $page }}
                        </a>
                     @endif
                  @endforeach
               @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
               <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pg-link pg-arrow pg-last"
                  aria-label="{{ __('pagination.next') }}">
                  <svg class="pg-icon" fill="currentColor" viewBox="0 0 20 20">
                     <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                  </svg>
               </a>
            @else
               <span class="pg-link pg-arrow pg-disabled pg-last" aria-disabled="true">
                  <svg class="pg-icon" fill="currentColor" viewBox="0 0 20 20">
                     <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                  </svg>
               </span>
            @endif
         </div>
      </div>
   </nav>
@endif

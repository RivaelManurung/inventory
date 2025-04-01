<div class="row mt-3">
    <div class="col-md-6">
        <div class="pagination-info">
            @if(isset($jenisBarangs->total))
                Menampilkan
                {{ (($jenisBarangs->current_page ?? 1) - 1) * ($jenisBarangs->per_page ?? 10) + 1 }}
                sampai
                {{ min(($jenisBarangs->current_page ?? 1) * ($jenisBarangs->per_page ?? 10), $jenisBarangs->total) }}
                dari {{ $jenisBarangs->total }} entri
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                @isset($jenisBarangs->links)
                    @foreach ($jenisBarangs->links as $link)
                        <li class="page-item {{ isset($link->active) && $link->active ? 'active' : '' }} {{ empty($link->url) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $link->url ?? '#' }}" {!! empty($link->url) ? 'tabindex="-1"' : '' !!}>
                                {!! $link->label ?? '' !!}
                            </a>
                        </li>
                    @endforeach
                @endisset
            </ul>
        </nav>
    </div>
</div>
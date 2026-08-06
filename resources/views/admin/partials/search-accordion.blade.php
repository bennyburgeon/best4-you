<div class="accordion mb-4" id="searchAccordionParent">
    <div class="accordion-item border rounded-3 shadow-none">
        <h2 class="accordion-header" id="headingSearch">
            <button class="accordion-button collapsed fw-bold text-dark py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch">
                <i class="bx bx-search fs-4 me-2"></i> Search
            </button>
        </h2>
        <div id="collapseSearch" class="accordion-collapse collapse" aria-labelledby="headingSearch" data-bs-parent="#searchAccordionParent">
            <div class="accordion-body bg-light rounded-bottom py-3">
                <form id="searchForm">
                    <div class="row g-3">
                        @foreach($fields as $field)
                            <div class="{{ $field['class'] ?? 'col-md-4' }}">
                                <label for="search_{{ $field['name'] }}" class="form-label small fw-bold text-muted text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">{{ $field['label'] }}</label>
                                @if(($field['type'] ?? 'text') === 'select')
                                    <select class="form-select" id="search_{{ $field['name'] }}" name="{{ $field['name'] }}">
                                        <option value="">All</option>
                                        @foreach($field['options'] as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" class="form-control {{ ($field['name'] === 'date_range' || ($field['input_class'] ?? '') === 'flatpickr-range') ? 'flatpickr-range' : '' }}" id="search_{{ $field['name'] }}" name="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] ?? '' }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@php
    $escapedTitle = e($row->title);
    $escapedCode = e($row->job_code ?? 'N/A');

    // Clean HTML tags from roles and responsibility description for simple copying
    $cleanDesc = strip_tags(
        str_replace(
            ['<p>', '</p>', '<div>', '</div>', '<li>', '</li>', '<br>', '<br/>', '<br />'],
            "\n",
            $row->roles_and_responsibility ?? ''
        )
    );
    $cleanDesc = str_replace('•', "\n• ", $cleanDesc);
    $cleanDesc = preg_replace("/\n+/", "\n", $cleanDesc);
    $cleanDesc = trim($cleanDesc);
    $escapedDesc = e($cleanDesc);

    $skillsStr = $row->skills->pluck('name')->implode(', ') ?: 'N/A';
    $escapedSkills = e($skillsStr);

    $categoryName = $row->category ? $row->category->name : 'N/A';
    $jobTypeName = $row->jobType ? $row->jobType->name : 'N/A';
    $industryName = $row->industryType ? $row->industryType->name : 'N/A';

    $expMin = $row->experience_min;
    $expMax = $row->experience_max;
    $experienceStr = ($expMin !== null && $expMax !== null) ? ($expMin . ' - ' . $expMax . ' years') : 'Not Specified';

    $currencySymbol = $row->currency ? $row->currency->symbol : '$';
    $salaryStr = ($row->salary_from && $row->salary_to) ? ($currencySymbol . ' ' . $row->salary_from . ' - ' . $row->salary_to) : 'Not Specified';

    $openingStr = $row->opening_date ? $row->opening_date->format('M d, Y') : 'N/A';
    $closingStr = $row->closing_date ? $row->closing_date->format('M d, Y') : 'N/A';
    
    $applyLink = request()->getSchemeAndHttpHost() . '/jobs/' . ($row->job_code ?? $row->id);
@endphp

<div class="d-flex justify-content-center gap-1">
    <button type="button" class="btn btn-sm btn-outline-primary copy-job-btn"
            data-title="{{ $escapedTitle }}"
            data-code="{{ $escapedCode }}"
            data-description="{{ $escapedDesc }}"
            data-skills="{{ $escapedSkills }}"
            data-opening="{{ $openingStr }}"
            data-closing="{{ $closingStr }}"
            data-category="{{ e($categoryName) }}"
            data-jobtype="{{ e($jobTypeName) }}"
            data-industry="{{ e($industryName) }}"
            data-experience="{{ e($experienceStr) }}"
            data-salary="{{ e($salaryStr) }}"
            data-link="{{ e($applyLink) }}">
        <i class="bx bx-copy"></i> Copy
    </button>

    <a href="{{ route('jobs.edit', $row->id) }}" class="btn btn-sm btn-info text-white">
        <i class="bx bx-edit-alt"></i> Edit
    </a>

    <form action="{{ route('jobs.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this job?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="bx bx-trash"></i> Delete
        </button>
    </form>
</div>

<div>
    <p {{ $attributes->merge(['class' => 'text-center text-xs text-80']) }}>

        <x-versioning-helper-application-name :linkClasses="$linkClasses"></x-versioning-helper-application-name>

        <span class="px-1">&middot;</span>
        <x-versioning-helper-copyright :linkClasses="$linkClasses"></x-versioning-helper-copyright>

        <span class="px-1">&middot;</span>
        <x-versioning-helper-version :linkClasses="$linkClasses"></x-versioning-helper-version>

    </p>
</div>

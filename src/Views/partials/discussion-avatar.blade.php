<avatar-placeholder
    class="flex items-center justify-center flex-shrink-0 @if (($size ?? false) && $size == 'lg') {{ 'w-12 h-12 text-lg' }}@elseif(($size ?? false) && $size == 'xs'){{ 'w-6 h-6 text-xs' }}@elseif(($size ?? false) && $size == 'sm'){{ 'w-8 h-8 text-sm' }}@else{{ 'w-10 h-10 text-base' }} @endif font-bold text-white rounded-full select-none"
    style="background:#<?= FoundationApp\Discussions\Helpers\Avatar::stringToColorCode($user->name) ?>">
    {{ FoundationApp\Discussions\Helpers\Avatar::getInitials($user->name) }}
</avatar-placeholder>

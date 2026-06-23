@props(['for'])

@error($for)
    <span class="text-red-500 text-xs mt-1 block animate-pulse">
        {{ $message }}
    </span>
@enderror

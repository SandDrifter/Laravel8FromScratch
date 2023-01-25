@props(['trigger'])
<div x-data="{ show: false }" @click.away="show = false" class="relative">
    {{--     Trigger --}}
    <div @click="show = ! show">
        {{ $trigger }}
    </div>
   {{--  Links --}}
    <div x-show="show" class="py-2 absolute bg-gray-100 mt-2 w-full rounded-xlblue 5 z-50 overflow-auto max-h-52" style="display: none">
       {{ $slot }}
    </div>
</div>
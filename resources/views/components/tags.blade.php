<div x-data="tags({
        searchInput: '',
        tags: $wire.entangle('{{ $field->key }}'){{ $field->deferString }},
        open: false, {{-- not used in this component, only here because this comp shares js with TagsSearch --}}
    })"
    x-on:click.away="clearInput" class="{{$field->wrapperClass}}">
    <div @class([
            'block w-full transition duration-75 divide-y rounded focus-within:shadow-md border overflow-hidden',
            'border-gray-300 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500' => !$errors->has("$field->key.*"),
            'shake border-red-500 ring-red-500 focus-within:border-red-500 focus-within:ring-2 focus-within:ring-red-500' => $errors->has("$field->key.*"),
    ])>
        @unless($field->disabled)
            <input
                autocomplete="off"
                placeholder="{{ $field->placeholder }}"
                id="{{ $field->id }}"
                type="text"
                x-on:keydown.enter.stop.prevent="addTag"
                x-on:keydown.,.stop.prevent="addTag"
                x-on:keydown.period.stop.prevent="addTag"
                x-on:keydown.space.stop.prevent="addTag"
                x-on:keydown.escape="clearInput"
                x-on:keydown.clear="clearInput"
                x-on:keydown.delete="clearInput"
                x-model="searchInput"
                class="block w-full border-0"
            />
        @endunless

        <div x-show="tags.length" class="bg-white relative w-full pb-2 space-x-2 space-y-2">
            @php $hasErrors = json_encode($errors->has($field->key.'.*')); @endphp
            <template x-for="tag in tags" x-bind:key="tag">
                <button
                    type="button"
                    @if($field->disabled)
                    x-on:click.prevent.stop
                    @else
                    x-on:click="deleteTag(tag, {{ $hasErrors }})"
                    @endif
                    @class([
                        'tf-tags-color inline-flex leading-4 items-center text-sm rounded py-1 px-2 space-x-1',
                        'cursor-default' => $field->disabled,
                    ])>
                    <span x-text="tag"></span>

                    @unless($field->disabled)
                        <span class="tf-tags-x-color">x</span>
                    @endunless
                </button>
            </template>
        </div>
    </div>
</div>
@tfonce('scripts:tagscomponent')
@include('tall-forms::includes.tags-js')
@endtfonce

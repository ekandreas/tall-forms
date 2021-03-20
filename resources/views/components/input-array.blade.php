<div x-data="{ inputArray: @entangle($field->key){{$field->defer}} }">
    <div @error($field->key.'.*') class="{{ $error() }}" @enderror>
        <template x-for="(item, index) in inputArray" :key="index">
            <div class="flex md:space-x-2 space-x-1">
                <input x-model="inputArray[index]"
                @foreach($options() as $key => $value) {{$key}}="{{$value}}" @endforeach
                />
                <button type="button" class="tf-repeater-delete-btn" x-on:click.prevent.prevent="inputArray.splice(index, 1)">
                    <x-tall-svg :path="config('tall-forms.trash-icon')" class="tf-repeater-btn-size" />
                </button>
            </div>
        </template>
        @error($field->key.'.*')
        <p class="tf-error">
            {{ $field->errorMsg ?? \Tanthammar\TallForms\ErrorMessage::parse($message) }}
        </p>
        @enderror
    </div>
    <button type="button" class="tf-repeater-add-button" x-on:click.prevent="inputArray = Array.from(inputArray.filter(item => item.length > 0)); inputArray.push('')" style="width:fit-content">
        <x-tall-svg :path="config('tall-forms.plus-icon')" class="tf-repeater-add-button-size" />
    </button>
</div>

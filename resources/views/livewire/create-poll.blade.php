<div>
    <form wire:submit.prevent="createPoll">
        <label>Poll Title</label>

        <input wire:model.live="title" type="text" />

        <div class="mb-4 mt-4">
            <button class="btn" wire:click.prevent="addOption">Add Option</button>
        </div>

        @foreach ($options as $index => $option)
            <div class="mb-3">
                <label>Option {{ $index + 1 }}</label>
            </div>

            <div class="flex gap-2 mb-3">
                <input type="text" wire:model.live="options.{{ $index }}" />
                <button class="btn" wire:click.prevent="removeOption({{ $index }})">Remove</button>
            </div>
        @endforeach

        <button type="submit" class="btn">Create Poll</button>
    </form>
</div>

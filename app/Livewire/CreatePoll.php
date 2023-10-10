<?php

namespace App\Livewire;

use App\Models\Poll;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreatePoll extends Component
{
    public $title;
    public $options = [''];

    public function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'options' => 'required|array|min:1|max:10',
            'options.*' => 'required|min:1|max:255',
        ];
    }

    public function messages()
    {
        return [
            'options.*' => 'The option can\'t be empty.',
        ];
    }


    public function render()
    {
        return view('livewire.create-poll');
    }

    /**
     * Add an option to the options array.
     *
     * @return void
     */
    public function addOption()
    {
        $this->options[] = '';
    }

    /**
     * Remove an option from the options array.
     *
     * @param int $index The index of the option to remove.
     * @return void
     */
    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options); // Rebuild array indexation to avoid index gaps
    }

    /**
     * Creates a new poll.
     *
     * This function creates a new poll by validating the input data,
     * creating a new Poll model with the provided title, and creating
     * multiple options for the poll using the provided options array.
     * The function then resets the title and options, and dispatches
     * the 'pollCreated' event.
     *
     * @throws Some_Exception_Class If validation fails.
     * @return void
     */
    public function createPoll()
    {
        $this->validate();

        Poll::create([
            'title' => $this->title
        ])->options()->createMany(
            collect($this->options)
                ->map(fn($option) => ['name' => $option])
                ->all()
        );

        $poll = Poll::create([
            'title' => $this->title
        ]);

        // OLD method before adding above block ->options()->createMany()...
        //
        // foreach ($this->options as $optionName) {
        //     $poll->options()->create(['name' => $optionName]);
        // }

        $this->reset(['title', 'options']);

        $this->dispatch('pollCreated');
    }

    // public function mount()
    // {

    // }


}

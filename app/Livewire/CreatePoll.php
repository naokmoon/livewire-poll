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

    protected $messages = [
        'options.*' => 'The option can\'t be empty 123.',
    ];

    public function render()
    {
        return view('livewire.create-poll');
    }

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options); // Rebuild array indexation to avoid index gaps
    }

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

        // OLD method before adding above block ->options()->createMany()...
        //
        // foreach ($this->options as $optionName) {
        //     $poll->options()->create(['name' => $optionName]);
        // }

        $this->reset(['title', 'options']);
    }

    // public function mount()
    // {

    // }
}

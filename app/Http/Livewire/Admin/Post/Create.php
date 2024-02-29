<?php

namespace App\Http\Livewire\Admin\Post;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $content;
    public $image;
    
    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',        
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Post') ])]);
        
        if($this->getPropertyValue('image') and is_object($this->image)) {
            $this->image = $this->getPropertyValue('image')->store('/');
        }

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image,
            'user_id' => auth()->id(),
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.post.create')
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Post') ])]);
    }
}

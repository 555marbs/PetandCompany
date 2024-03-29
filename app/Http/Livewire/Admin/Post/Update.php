<?php

namespace App\Http\Livewire\Admin\Post;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $post;

    public $title;
    public $content;
    
    protected $rules = [
        'title' => 'required|max:30',
        'content' => 'required|max:255',        
    ];

    public function mount(Post $Post){
        $this->post = $Post;
        $this->title = $this->post->title;
        $this->content = $this->post->content;        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Post') ]) ]);
        
        $this->post->update([
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.post.update', [
            'post' => $this->post
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Post') ])]);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Obj;
use Livewire\Component;

class FileBrowser extends Component
{

    public $object;

    public $creatingNewFolder = false;

    public $newFolderState = [
        'name' => ''
    ];

    public function mount(Obj $object)
    {
        $this->object = $object;
    }

    protected $rules = [
        'newFolderState.name' => 'required|max:255'
    ];

    public function createFolder()
    {
        $this->validate();

        $object = $this->currentTeam->objects()->make([
            'parent_id' => $this->object->id
        ]);

        $folder = $this->currentTeam->folders()->create($this->newFolderState);

        $object->objectable()->associate($folder);

        $object->save();

        $this->creatingNewFolder = false;

        $this->newFolderState = [
            'name' => ''
        ];

        $this->object = $this->object->fresh();
    }

    public function getCurrentTeamProperty()
    {
        return auth()->user()->currentTeam;
    }

    public function render()
    {
        return view('livewire.file-browser', [
            'ancestors' => $this->object->ancestors()
        ]);
    }
}

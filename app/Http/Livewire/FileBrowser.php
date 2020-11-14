<?php

namespace App\Http\Livewire;

use App\Models\Obj;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileBrowser extends Component
{

    use WithFileUploads;

    public $object;

    public $upload;

    public $creatingNewFolder = false;

    public $newFolderState = [
        'name' => ''
    ];

    public $renamingObject;

    public $renamingObjectState = [
        'name' => ''
    ];

    public $showFileUploadForm = false;

    public function mount(Obj $object)
    {
        $this->object = $object;
    }

    protected $rules = [
        'newFolderState.name' => 'required|max:255'
    ];

    public function updatedUpload($upload)
    {
        $object = $this->currentTeam->objects()->make([
            'parent_id' => $this->object->id
        ]);

        $file = $this->currentTeam->files()->create([
            'name' => $upload->getClientOriginalName(),
            'size' => $upload->getSize(),
            'path' => $upload->storePublicly('files', [
                'disk' => 'local'
            ])
        ]);

        $object->objectable()->associate($file);

        $object->save();

        $this->object = $this->object->fresh();
    }

    public function updatingRenamingObject($id)
    {
        if (!$id) {
            $this->renamingObjectState = [
                'name' => ''
            ];
            return;
        }

        if ($object = Obj::forCurrentTeam()->find($id)) {
            $this->renamingObjectState = [
                'name' => $object->objectable->name
            ];
        }
    }

    public function renameObject()
    {
        $this->validate([
            'renamingObjectState.name' => 'required|max:255'
        ]);

        Obj::forCurrentTeam()->find($this->renamingObject)
                             ->objectable
                             ->update($this->renamingObjectState);

        $this->object = $this->object->fresh();

        $this->renamingObject = null;

    }

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

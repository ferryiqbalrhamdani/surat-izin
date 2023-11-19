<?php

namespace App\Livewire\DataMaster;

use App\Models\Role as ModelsRole;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class Role extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $id_role;

    public $perPage = 5;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';

    #[Rule('required|string', as: 'Nama role')]
    public $name = '';


    public function sortBy($sortField)
    {
        if ($this->sortField === $sortField) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $sortField;
    }

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function addRole()
    {
        $this->validate([
            'name' => 'required|string',
        ]);


        ModelsRole::create([
            'name' => $this->name
        ]);

        Alert::toast('Data berhasil ditambah.', 'success');
        return redirect('role');
    }

    public function ubahRole($id)
    {
        $this->id_role = $id;

        $data = ModelsRole::where('id', $this->id_role)->first();
        $this->name = $data->name;

        $this->dispatch('show-edit-modal');
    }

    public function update()
    {
        ModelsRole::where('id', $this->id_role)->update([
            'name' => $this->name,
        ]);

        $this->id_role = '';
        $this->name = '';

        $this->dispatch('close-edit-modal');
        $this->dispatch('update', [
            'title' => 'Data Berhasil diubah!',
            'icon' => 'success',
        ]);
    }

    public function hapusRole($id)
    {
        $this->id_role = $id;

        $data = ModelsRole::where('id', $this->id_role)->first();
        $this->name = $data->name;

        $this->dispatch('show-delete-modal');
    }

    public function destroy()
    {
        ModelsRole::where('id', $this->id_role)->delete();

        $this->id_role = '';
        $this->name = '';

        $this->dispatch('close-delete-modal');
        $this->dispatch('swal', [
            'title' => 'Data Berhasil dihapus!',
            'icon' => 'success',
        ]);
    }

    public function closeHapus()
    {
        $this->id_role = '';
        $this->name = '';
    }

    #[Title('Data Role')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data-master.role', [
            'dataRole' => ModelsRole::where('name', 'like', '%' . $this->search . '%')->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage),
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }
}

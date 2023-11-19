<?php

namespace App\Livewire\DataMaster;

use App\Models\PT;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class DataPt extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $id_pt;

    public $perPage = 5;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';

    #[Rule('required|string', as: 'Nama PT')]
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

    public function addPT()
    {
        $this->validate([
            'name' => 'required|string',
        ]);


        PT::create([
            'name' => $this->name
        ]);

        Alert::toast('Data berhasil ditambah.', 'success');
        return redirect('pt');
    }

    public function ubahPT($id)
    {
        $this->id_pt = $id;

        $data = PT::where('id', $this->id_pt)->first();
        $this->name = $data->name;

        $this->dispatch('show-edit-modal');
    }

    public function update()
    {
        PT::where('id', $this->id_pt)->update([
            'name' => $this->name,
        ]);

        $this->id_pt = '';
        $this->name = '';

        $this->dispatch('close-edit-modal');
        $this->dispatch('update', [
            'title' => 'Data Berhasil diubah!',
            'icon' => 'success',
        ]);
    }

    public function hapusPT($id)
    {
        $this->id_pt = $id;

        $data = PT::where('id', $this->id_pt)->first();
        $this->name = $data->name;

        $this->dispatch('show-delete-modal');
    }

    public function destroy()
    {
        PT::where('id', $this->id_pt)->delete();

        $this->id_pt = '';
        $this->name = '';

        $this->dispatch('close-delete-modal');
        $this->dispatch('swal', [
            'title' => 'Data Berhasil dihapus!',
            'icon' => 'success',
        ]);
    }

    public function closeHapus()
    {
        $this->id_pt = '';
        $this->name = '';
    }

    #[Title('Data PT')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data-master.data-pt', [
            'dataPT' => PT::where('name', 'like', '%' . $this->search . '%')->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage),
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

<?php

namespace App\Livewire\DataMaster;

use App\Models\Divisi;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class DataDivisi extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $id_divisi;

    public $perPage = 5;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';

    #[Rule('required|string', as: 'Nama divisi')]
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

    public function addDivisi()
    {
        $this->validate([
            'name' => 'required|string',
        ]);


        Divisi::create([
            'name' => $this->name
        ]);

        Alert::toast('Data berhasil ditambah.', 'success');
        return redirect('divisi');
    }

    public function ubahDivisi($id)
    {
        $this->id_divisi = $id;

        $data = Divisi::where('id', $this->id_divisi)->first();
        $this->name = $data->name;

        $this->dispatch('show-edit-modal');
    }

    public function update()
    {
        Divisi::where('id', $this->id_divisi)->update([
            'name' => $this->name,
        ]);

        $this->id_divisi = '';
        $this->name = '';

        $this->dispatch('close-edit-modal');
        $this->dispatch('update', [
            'title' => 'Data Berhasil diubah!',
            'icon' => 'success',
        ]);
    }

    public function hapusDivisi($id)
    {
        $this->id_divisi = $id;

        $data = Divisi::where('id', $this->id_divisi)->first();
        $this->name = $data->name;

        $this->dispatch('show-delete-modal');
    }

    public function destroy()
    {
        Divisi::where('id', $this->id_divisi)->delete();

        $this->id_divisi = '';
        $this->name = '';

        $this->dispatch('close-delete-modal');
        $this->dispatch('swal', [
            'title' => 'Data Berhasil dihapus!',
            'icon' => 'success',
        ]);
    }

    public function closeHapus()
    {
        $this->id_divisi = '';
        $this->name = '';
    }

    #[Title('Data Divisi')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data-master.data-divisi', [
            'dataDivisi' => Divisi::where('name', 'like', '%' . $this->search . '%')->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage),
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

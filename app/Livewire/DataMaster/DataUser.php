<?php

namespace App\Livewire\DataMaster;

use App\Models\Divisi;
use App\Models\Permission;
use App\Models\PT;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class DataUser extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $id_user, $status;

    public $perPage = 5;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    #[Url()]
    public $search = '';

    // #[Rule('required|string|alpha_dash|min:3|unique:users,username')]
    #[Rule('required|string|alpha_dash|min:3')]
    public $username;
    #[Rule('required|string')]
    public $name;
    #[Rule('required|min:3')]
    public $password;
    #[Rule('required|string')]
    public $jk = 'L';
    #[Rule('required', as: 'divisi')]
    public $divisi_id;
    #[Rule('required', as: 'PT')]
    public $pt_id;
    #[Rule('required', as: 'role user')]
    public $role_id;

    public $pt = [];
    public $divisi = [];
    public $role = [];
    public $permissions = [];
    public $has_role = [];

    public $showpassword = false;

    public function mount()
    {
        $this->pt = PT::all();
        $this->divisi = Divisi::all();
        $this->role = Role::all();
        $this->permissions = Permission::all();
        $this->has_role = DB::table('role_has_permissions')->get();
    }

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

    public function openPas()
    {
        $this->showpassword = !$this->showpassword;
    }

    // ----------- tambah ----------------------

    public function addUser()
    {
        $this->validate([
            'username' => 'required|string|alpha_dash|min:3|unique:users,username',
            'name' => 'required|string',
            'password' => 'required|string',
            'jk' => 'required|string',
            'divisi_id' => 'required',
            'pt_id' => 'required',
            'role_id' => 'required',
        ]);

        User::create([
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'name' => $this->name,
            'jk' => $this->jk,
            'pt_id' => $this->pt_id,
            'divisi_id' => $this->divisi_id,
            'role_id' => $this->role_id,
        ]);

        Alert::toast('Data berhasil ditambahkan.', 'success');
        return redirect('user');
    }

    // ---------------- hapus --------------------------

    public function hapusUser($id)
    {
        $this->id_user = $id;

        $data = User::where('id', $this->id_user)->first();
        $this->name = $data->name;

        $this->dispatch('show-delete-modal');
    }

    public function destroy()
    {
        User::where('id', $this->id_user)->delete();

        $this->id_user = '';
        $this->name = '';

        $this->dispatch('close-delete-modal');
        $this->dispatch('delete', [
            'title' => 'Data Berhasil dihapus!',
            'icon' => 'success',
        ]);
    }

    public function closeHapus()
    {
        $this->id_user = '';
        $this->name = '';
    }

    // ------------------ ubah -----------------------
    public function ubahUser($id)
    {
        $this->id_user = $id;
        $data = User::where('id', $this->id_user)->first();

        $this->username = $data->username;
        $this->name = $data->name;
        $this->jk = $data->jk;
        $this->pt_id = $data->pt_id;
        $this->divisi_id = $data->divisi_id;
        $this->role_id = $data->role_id;
        $this->status = $data->status;

        $this->dispatch('show-update-modal');
    }

    public function edit()
    {
        $this->validate([
            'username' => 'required|string|alpha_dash|min:3|unique:users,username,' . $this->id_user,
            'name' => 'required|string',
            'jk' => 'required|string',
            'pt_id' => 'required',
            'divisi_id' => 'required',
            'role_id' => 'required',
            'status' => 'required',
        ]);

        User::where('id', $this->id_user)->update([
            'username' => $this->username,
            'name' => $this->name,
            'jk' => $this->jk,
            'pt_id' => $this->pt_id,
            'divisi_id' => $this->divisi_id,
            'role_id' => $this->role_id,
            'status' => $this->status,
        ]);

        $this->username = '';
        $this->name = '';
        $this->password = '';
        $this->jk = 'L';
        $this->pt_id = '';
        $this->divisi_id = '';
        $this->role_id = '';
        $this->status = '';

        $this->dispatch('close-update-modal');
        $this->dispatch('update', [
            'title' => 'Data Berhasil diubah!',
            'icon' => 'success',
        ]);
    }

    public function closeUbah()
    {
        $this->username = '';
        $this->name = '';
        $this->jk = 'L';
        $this->pt_id = '';
        $this->divisi_id = '';
        $this->role_id = '';
        $this->status = '';
    }

    // ---------------- reset password ---------------
    public function resetUser($id)
    {
        $this->id_user = $id;

        $data = User::where('id', $this->id_user)->first();
        $this->name = $data->name;

        $this->dispatch('show-reset-modal');
    }

    public function resetAction()
    {
        User::where('id', $this->id_user)->update([
            'password' => Hash::make('user123')
        ]);

        $this->id_user = '';
        $this->name = '';


        $this->dispatch('close-reset-modal');
        $this->dispatch('reset', [
            'title' => 'Password berhasil diubah!',
            'icon' => 'success',
        ]);
    }

    #[Title('Data User')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.data-master.data-user', [
            'user' => User::where('name', 'like', '%' . $this->search . '%')->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage),
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

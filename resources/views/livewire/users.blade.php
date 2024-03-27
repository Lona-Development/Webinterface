<div>
    @if($warning !== "")
        <div class="p-3 m-2 bg-danger bg-opacity-10 border border-danger rounded text-danger">
            {{$warning}}
        </div>
    @endif

    @if($success !== "")
        <div class="p-3 m-2 bg-success bg-opacity-10 border border-success rounded text-success">
            {{$success}}
        </div>
    @endif

    <br/> <br/> <br/> <br/>

    <div class="main border border-secondary rounded">
        <p class="fs-2">Users</p>
        @if ($this->users)
        <button wire:click="newUser" class="list-button bg-success bg-opacity-75 border border-success rounded text-light right mb-2"><i class="fa-solid fa-plus"></i> <span>Create</span></button>
        @endif
        </br> </br>
    @foreach ($this->userList as $user => $role)
        <div class="table">
            <button wire:click.prevent="viewUser('{{$user}}')" class="list-button bg-success bg-opacity-75 border border-success rounded text-light p-1"><i class="fa-solid fa-eye"></i> <span>{{$user}}</span></button>
            @if($role !== "Administrator")<button wire:click.prevent="deleteUserModal('{{$user}}')" class="list-button bg-danger bg-opacity-75 border border-danger rounded text-light rounded p-1"><i class="fa-solid fa-trash"></i></button>@endif
        </div>
    @endforeach
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createModalLabel">New User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Name</label>
                    <input wire:model="userName" type="text" class="form-control" id="recipient-name">
                </div>

                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Password</label>
                    <input wire:model="userPassword" type="password" class="form-control" id="recipient-name">
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="bg-danger bg-opacity-75 border border-danger rounded text-light" data-bs-dismiss="modal">Cancel</button>
                <button wire:click="createUser" type="button" class="bg-success bg-opacity-75 border border-success rounded text-light">Create</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 overflow-2" id="deleteModalLabel">{{$this->deleteUserName}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the User?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="bg-danger bg-opacity-75 border border-danger rounded text-light" data-bs-dismiss="modal">Cancel</button>
                <button wire:click="deleteUser" type="button" class="bg-success bg-opacity-75 border border-success rounded text-light">Delete</button>
            </div>
            </div>
        </div>
    </div>


    @script
    <script>
        window.addEventListener('showCreate', event => {
            $('#createModal').modal('show');
        });

        window.addEventListener('hideCreate', event => {
            $('#createModal').modal('hide');
        });

        window.addEventListener('showDelete', event => {
            $('#deleteModal').modal('show');
        });

        window.addEventListener('hideDelete', event => {
            $('#deleteModal').modal('hide');
        });
    </script>
    @endscript
</div>
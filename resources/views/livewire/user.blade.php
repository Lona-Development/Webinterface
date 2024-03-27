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
        <p class="fs-2">{{$user}}</p>
        <button wire:click.prevent="addPermissionModal" class="list-button bg-success bg-opacity-75 border border-success rounded text-light right mb-2"><i class="fa-solid fa-plus"></i> <span>Create</span></button>
        @if($this->roles)<button wire:click.prevent="promoDemo" class="list-button bg-warning bg-opacity-75 border border-warning rounded text-light right mb-2 mr-2"><i class="fa-solid fa-pen-to-square"></i> <span>@if($this->userRole === 'Administrator') Demote @else Promote @endif</span></button>@endif
        <table class="table">
            <thead>
                <th>Permisison</th>
                <th>Allowed</th>
                <th></th>
            </thead>
            <tbody>
            @foreach ($this->permissionList as $permission => $allow)
                <tr>
                    <td><p class="overflow">{{$permission}}</p></td>
                    <td><p class="overflow @if($allow === true) text-success @else text-danger @endif">@if($allow === true) True @else False @endif</p></td>
                    <td>
                        <button wire:click.prevent="removePermissionModal('{{$permission}}')" class="list-button bg-danger bg-opacity-75 border border-danger rounded text-light rounded p-1"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createModalLabel">Add permission</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="addPermission">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Permission</label>
                        <input wire:model="permission" type="text" class="form-control" id="recipient-name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="bg-danger bg-opacity-75 border border-danger rounded text-light" data-bs-dismiss="modal">Cancel</button>
                <button wire:click.prevent="addPermission" type="button" class="bg-success bg-opacity-75 border border-success rounded text-light">Add</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 overflow-2" id="deleteModalLabel">{{$this->permission}}</span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this permission?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="bg-danger bg-opacity-75 border border-danger rounded text-light" data-bs-dismiss="modal">Cancel</button>
                <button wire:click="removePermission" type="button" class="bg-success bg-opacity-75 border border-success rounded text-light">Delete</button>
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
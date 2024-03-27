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
        <p class="fs-2">{{$table}}</p>
        <button wire:click.prevent="newVariable" class="list-button bg-success bg-opacity-75 border border-success rounded text-light right mb-2"><i class="fa-solid fa-plus"></i> <span>Create</span></button>
    
        <table class="table">
            <thead>
                <th>Key</th>
                <th>Value</th>
                <th></th>
            </thead>
            <tbody>
            @foreach ($this->tableData as $key => $value)
                <tr>
                    <td><p class="overflow">{{$key}}</p></td>
                    <td><p class="overflow">
                        @if (!is_string($value)) 
                            @if ($value === true || $value === false) <p class="@if ($value === false) text-danger @else text-success @endif">{{json_encode($value)}}</p>
                            @elseif(is_float($value) || is_int($value))<p class="text-info">{{$value}}</p>
                            @else <p class="text-warning">{{json_encode($value)}}</p> 
                        @endif 
                        @else 
                            {{$value}} 
                        @endif
                    </p></td>
                    <td>
                        <button wire:click.prevent="editKey('{{$key}}')" class="list-button bg-info bg-opacity-75 border border-info rounded text-light rounded p-1"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button wire:click.prevent="deleteKey('{{$key}}')" class="list-button bg-danger bg-opacity-75 border border-danger rounded text-light rounded p-1"><i class="fa-solid fa-trash"></i></button>
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
                <h1 class="modal-title fs-5" id="createModalLabel">Set variable</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="createVariable">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Key</label>
                        <input wire:model="key" type="text" class="form-control" id="recipient-name">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Value</label>
                        <input wire:model="value" type="text" class="form-control" id="recipient-name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="bg-danger bg-opacity-75 border border-danger rounded text-light" data-bs-dismiss="modal">Cancel</button>
                <button wire:click.prevent="createVariable" type="button" class="bg-success bg-opacity-75 border border-success rounded text-light">Set</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 overflow-2" id="deleteModalLabel">{{$this->key}}</span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the variable?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="bg-danger bg-opacity-75 border border-danger rounded text-light" data-bs-dismiss="modal">Cancel</button>
                <button wire:click="deleteVariable" type="button" class="bg-success bg-opacity-75 border border-success rounded text-light">Delete</button>
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
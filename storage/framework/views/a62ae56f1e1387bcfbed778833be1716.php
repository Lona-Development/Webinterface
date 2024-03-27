<div>
    <!--[if BLOCK]><![endif]--><?php if($warning !== ""): ?>
        <div class="p-3 m-2 bg-danger bg-opacity-10 border border-danger rounded text-danger">
            <?php echo e($warning); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if($success !== ""): ?>
        <div class="p-3 m-2 bg-success bg-opacity-10 border border-success rounded text-success">
            <?php echo e($success); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <br/> <br/> <br/> <br/>

    <div class="main border border-secondary rounded">
        <p class="fs-2"><?php echo e($table); ?></p>
        <button wire:click.prevent="newVariable" class="list-button bg-success bg-opacity-75 border border-success rounded text-light right mb-2"><i class="fa-solid fa-plus"></i> <span>Create</span></button>
    
        <table class="table">
            <thead>
                <th>Key</th>
                <th>Value</th>
                <th></th>
            </thead>
            <tbody>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->tableData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><p class="overflow"><?php echo e($key); ?></p></td>
                    <td><p class="overflow">
                        <!--[if BLOCK]><![endif]--><?php if(!is_string($value)): ?> 
                            <!--[if BLOCK]><![endif]--><?php if($value === true || $value === false): ?> <p class="<?php if($value === false): ?> text-danger <?php else: ?> text-success <?php endif; ?>"><?php echo e(json_encode($value)); ?></p>
                            <?php elseif(is_float($value) || is_int($value)): ?><p class="text-info"><?php echo e($value); ?></p>
                            <?php else: ?> <p class="text-warning"><?php echo e(json_encode($value)); ?></p> 
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 
                        <?php else: ?> 
                            <?php echo e($value); ?> 
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </p></td>
                    <td>
                        <button wire:click.prevent="editKey('<?php echo e($key); ?>')" class="list-button bg-info bg-opacity-75 border border-info rounded text-light rounded p-1"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button wire:click.prevent="deleteKey('<?php echo e($key); ?>')" class="list-button bg-danger bg-opacity-75 border border-danger rounded text-light rounded p-1"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
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
                <h1 class="modal-title fs-5 overflow-2" id="deleteModalLabel"><?php echo e($this->key); ?></span></h1>
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

        <?php
        $__scriptKey = '4158810702-0';
        ob_start();
    ?>
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
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
</div><?php /**PATH /home/collin/Webinterface/laravel/resources/views/livewire/table.blade.php ENDPATH**/ ?>
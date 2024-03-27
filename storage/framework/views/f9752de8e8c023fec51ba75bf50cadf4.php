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
        <p class="fs-2"><?php echo e($user); ?></p>
        <button wire:click.prevent="addPermissionModal" class="list-button bg-success bg-opacity-75 border border-success rounded text-light right mb-2"><i class="fa-solid fa-plus"></i> <span>Create</span></button>
        <!--[if BLOCK]><![endif]--><?php if($this->roles): ?><button wire:click.prevent="promoDemo" class="list-button bg-warning bg-opacity-75 border border-warning rounded text-light right mb-2 mr-2"><i class="fa-solid fa-pen-to-square"></i> <span><!--[if BLOCK]><![endif]--><?php if($this->userRole === 'Administrator'): ?> Demote <?php else: ?> Promote <?php endif; ?><!--[if ENDBLOCK]><![endif]--></span></button><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <table class="table">
            <thead>
                <th>Permisison</th>
                <th>Allowed</th>
                <th></th>
            </thead>
            <tbody>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->permissionList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission => $allow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><p class="overflow"><?php echo e($permission); ?></p></td>
                    <td><p class="overflow <?php if($allow === true): ?> text-success <?php else: ?> text-danger <?php endif; ?>"><!--[if BLOCK]><![endif]--><?php if($allow === true): ?> True <?php else: ?> False <?php endif; ?><!--[if ENDBLOCK]><![endif]--></p></td>
                    <td>
                        <button wire:click.prevent="removePermissionModal('<?php echo e($permission); ?>')" class="list-button bg-danger bg-opacity-75 border border-danger rounded text-light rounded p-1"><i class="fa-solid fa-trash"></i></button>
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
                <h1 class="modal-title fs-5 overflow-2" id="deleteModalLabel"><?php echo e($this->permission); ?></span></h1>
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

        <?php
        $__scriptKey = '2992082011-0';
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
</div><?php /**PATH /home/collin/Webinterface/laravel/resources/views/livewire/user.blade.php ENDPATH**/ ?>
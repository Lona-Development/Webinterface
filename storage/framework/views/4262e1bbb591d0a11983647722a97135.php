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
        <p class="fs-2">Users</p>
        <!--[if BLOCK]><![endif]--><?php if($this->users): ?>
        <button wire:click="newUser" class="list-button bg-success bg-opacity-75 border border-success rounded text-light right mb-2"><i class="fa-solid fa-plus"></i> <span>Create</span></button>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </br> </br>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->userList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="table">
            <button wire:click.prevent="viewUser('<?php echo e($user); ?>')" class="list-button bg-success bg-opacity-75 border border-success rounded text-light p-1"><i class="fa-solid fa-eye"></i> <span><?php echo e($user); ?></span></button>
            <!--[if BLOCK]><![endif]--><?php if($role !== "Administrator"): ?><button wire:click.prevent="deleteUserModal('<?php echo e($user); ?>')" class="list-button bg-danger bg-opacity-75 border border-danger rounded text-light rounded p-1"><i class="fa-solid fa-trash"></i></button><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
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
                <h1 class="modal-title fs-5 overflow-2" id="deleteModalLabel"><?php echo e($this->deleteUserName); ?></h1>
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


        <?php
        $__scriptKey = '2456908412-0';
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
</div><?php /**PATH /home/collin/Webinterface/resources/views/livewire/users.blade.php ENDPATH**/ ?>
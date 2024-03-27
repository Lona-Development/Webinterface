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
    <div class="container">
        <form wire:submit.prevent="login" class="login border border-secondary rounded p-3">
            <div class="mb-3">
                <label class="form-label">Userame</label>
                <input wire:model="loginName" type="text" class="form-control login-input">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input wire:model="loginPassword" type="password" class="form-control login-input">
            </div>
            <button class="btn btn-outline-success bg-success bg-opacity-75 text-light pt-1 pb-1">Log in</button>
        </form>
    </div>
</div><?php /**PATH /home/collin/Webinterface/laravel/resources/views/livewire/login.blade.php ENDPATH**/ ?>
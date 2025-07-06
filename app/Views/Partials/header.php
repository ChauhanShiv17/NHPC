<?php helper('url'); ?>
    <img src="<?= base_url('assets/nhpc_logo.png') ?>" alt="NHPC Logo" style="height:100px; position:absolute; top:20px; right:30px;">
</header>
<?php if (session()->get('isLoggedIn')): ?>
    <a href="<?= site_url('my-profile') ?>">My Profile</a>
<?php endif; ?>

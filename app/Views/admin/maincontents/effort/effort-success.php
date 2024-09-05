<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style type="text/css">
    .confetti-containers{   
        height: 100vh;
        overflow: hidden;
    }
    .confetti-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 10;
        overflow: hidden;
    }

    .confetti {
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: red;
        opacity: 0.8;
        transform: rotate(0deg);
        animation: fall linear infinite;
    }

    @keyframes fall {
        to {
            transform: translateY(100vh) rotate(360deg);
            opacity: 0;
        }
    }

    /* Random colors for confetti */
    .confetti:nth-child(odd) {
        background-color: blue;
    }
    .confetti:nth-child(even) {
        background-color: green;
    }
    .confetti:nth-child(3n) {
        background-color: yellow;
    }
    .confetti:nth-child(4n) {
        background-color: pink;
    }
    .confetti:nth-child(5n) {
        background-color: purple;
    }

    /* Varying durations and delays for more randomness */
    .confetti:nth-child(2) {
        animation-duration: 3s;
        animation-delay: 0.5s;
    }
    .confetti:nth-child(3) {
        animation-duration: 4s;
        animation-delay: 0.2s;
    }
    .confetti:nth-child(4) {
        animation-duration: 2s;
        animation-delay: 0.7s;
    }
    .confetti:nth-child(5) {
        animation-duration: 5s;
        animation-delay: 0.1s;
    }
</style>
<div class="pagetitle">
    <h1><?=$page_header?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="row">
        <!-- <div class="col-xl-12">
            <?php if(session('success_message')){?>
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                    <?=session('success_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }?>
            <?php if(session('error_message')){?>
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                    <?=session('error_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }?>
        </div> -->
        <?php if(session('success_message')){?>
            <script type="text/javascript">
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?=session('success_message')?>',
                    confirmButtonText: 'OK'
                });
            </script>
        <?php }?>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="confetti-containers">
                        <h5 class="card-title">
                            <a href="<?=base_url('admin/' . $controller_route . '/add/')?>" class="btn btn-outline-success btn-sm">Add <?=$title?></a>
                            <a href="<?=base_url('admin/' . $controller_route . '/list/')?>" class="btn btn-outline-success btn-sm">Effort History</a>
                        </h5>
                        <p class="alert alert-success">Your Effort Has Been Submitted Successfully</p>
                        <div class="confetti-container"></div>
                    </div>   
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    const confettiContainer = document.querySelector('.confetti-container');

    // Generate 100 confetti elements
    for (let i = 0; i < 1000; i++) {
        const confetti = document.createElement('div');
        confetti.classList.add('confetti');

        // Randomize the starting position and size
        confetti.style.left = `${Math.random() * 100}vw`;
        confetti.style.width = `${Math.random() * 10 + 5}px`;
        confetti.style.height = `${Math.random() * 10 + 5}px`;
        
        // Randomize animation duration
        confetti.style.animationDuration = `${Math.random() * 3 + 2}s`;

        confettiContainer.appendChild(confetti);
    }
</script>
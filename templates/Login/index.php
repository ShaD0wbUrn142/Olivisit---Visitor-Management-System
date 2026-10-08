<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!--CSS STYLING--><?= $this->Html->css('login') ?>

<!--Body-->
<body>
    <div class="logo">
        <!--Logo-->
        <?= $this->Html->image(
            'login_logo.png',
            ['alt' => 'Company Logo',
            'width' => '100px', 'height' => '100px',
            'style' => 'border-radius: 10%; object-fit: cover;']
        ) ?>
    </div>
    
    <div class="login-container">
        <div class="flash-error">
            <b><?= $this->Flash->render() ?></b>
        </div>
        <h2>Login</h2>
        <?= $this->Form->create() ?>
        
            <!-- Email Field -->
            <div class="form-group">
            <label for="email">Please enter your email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                autocomplete="username" 
                required 
                placeholder="example@gmail.com">
            </div>

            <!-- Password Field -->
            <div class="form-group">
            <label for="password">Please enter your Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                autocomplete="current-password" 
                required 
                placeholder="ilikeMangoes1!">
            </div>

            <!-- Options Row -->
            <div class="form-options">
            <?php echo $this->Html->link(
                'Forgot password?',
                ['controller' => 'Login', 'action' => 'forgotPassword'],
                ['class' => 'forgot-link']
            ); ?>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">Sign In</button>
        <?= $this->Form->end() ?>
    </div>
</body>